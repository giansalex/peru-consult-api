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

    private function buildSchema()
    {
        $personType = new ObjectType([
            'name' => 'Person',
            'description' => 'Consulta DNI',
            'fields' => [
                'dni' => Type::string(),
                'nombres' => Type::string(),
                'apellidoPaterno' => Type::string(),
                'apellidoMaterno' => Type::string(),
                'codVerifica' => Type::string(),
            ],
            // using defaultFieldResolver
        ]);

        $companyType = new ObjectType([
            'name' => 'Company',
            'description' => 'Consulta RUC',
            'fields' => [
                'ruc' => Type::string(),
                'razonSocial' => Type::string(),
                'nombreComercial' => Type::string(),
                'telefonos' => Type::string(),
                'tipo' => Type::string(),
                'estado' => Type::string(),
                'condicion' => Type::string(),
                'direccion' => Type::string(),
                'fechaInscripcion' => Type::string(),
                'sistEmsion' => Type::string(),
                'sistContabilidad' => Type::string(),
                'actExterior' => Type::string(),
                'actEconomicas' => Type::string(),
                'cpPago' => Type::string(),
                'sistElectronica' => Type::string(),
                'fechaEmisorFe' => Type::string(),
                'cpeElectronico' => Type::string(),
                'fechaPle' => Type::string(),
                'padrones' => Type::string(),
            ],
        ]);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'person' => [
                    'type' => $personType,
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
                    'type' => $companyType,
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