<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/12/2017
 * Time: 10:53 AM
 */

namespace Peru\Api\Service;

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use Peru\Api\Repository\ConsultTypes;
use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Psr\Container\ContainerInterface;
use GraphQL\Error\FormattedError;

class GraphRunner
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Schema
     */
    private $schema;

    /**
     * GraphRunner constructor.
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->buildSchema();
    }

    /**
     * @param $query
     * @return array
     * @throws \Throwable
     */
    public function execute($query)
    {
        try {
            $result = GraphQL::executeQuery($this->schema, $query);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [FormattedError::createFromException($e)]
            ];
        }

        return $output;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function buildSchema()
    {
        $registry = $this->container->get(ConsultTypes::class);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'person' => [
                    'type' => $registry->get('Person'),
                    'args' => [
                        'dni' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) {
                        $service = $this->container->get(Dni::class);
                        $person = $service->get($args['dni']);
                        if ($person === false) {
                            return null;
                        }

                        return $person;
                    }
                ],
                'company' => [
                    'type' => $registry->get('Company'),
                    'args' => [
                        'ruc' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) {
                        $service = $this->container->get(Ruc::class);
                        $company = $service->get($args['ruc']);
                        if ($company === false) {
                            return null;
                        }

                        return $company;
                    }
                ],
            ]
        ]);

        $this->schema = new Schema([
            'query' => $queryType
        ]);
    }
}