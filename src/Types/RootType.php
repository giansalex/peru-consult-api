<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/12/2017
 * Time: 10:01 AM.
 */

declare(strict_types=1);

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Resolver\DniResolver;
use App\Resolver\RucResolver;
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
                    'resolve' => $container->get(DniResolver::class),
                ],
                'company' => [
                    'type' => $container->get(CompanyType::class),
                    'description' => 'Representa a una empresa',
                    'args' => [
                        'ruc' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => $container->get(RucResolver::class),
                ],
            ],
        ];

        parent::__construct($config);
    }
}
