<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/12/2017
 * Time: 10:01 AM.
 */

namespace Peru\Api\Repository;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Psr\Container\ContainerInterface;

class RootType extends ObjectType
{
    /**
     * RootType constructor.
     *
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $config = [
            'name' => 'Root',
            'description' => 'Consultas RUC y DNI.',
            'fields' => [
                'person' => [
                    'type' => $container->get(PersonType::class),
                    'description' => 'Representa a una persona',
                    'args' => [
                        'dni' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) use ($container) {
                        $service = $container->get(Dni::class);
                        $person = $service->get($args['dni']);
                        if ($person === false) {
                            $container->get('logger')->error($service->getError());

                            return null;
                        }

                        return $person;
                    },
                ],
                'company' => [
                    'type' => $container->get(CompanyType::class),
                    'description' => 'Representa a una empresa',
                    'args' => [
                        'ruc' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) use ($container) {
                        $service = $container->get(Ruc::class);
                        $company = $service->get($args['ruc']);
                        if ($company === false) {
                            $container->get('logger')->error($service->getError());

                            return null;
                        }

                        return $company;
                    },
                ],
            ],
        ];

        parent::__construct($config);
    }
}
