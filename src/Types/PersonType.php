<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/12/2017
 * Time: 09:57 AM.
 */

declare(strict_types=1);

namespace App\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PersonType extends ObjectType
{
    /**
     * PersonType constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Person',
            'description' => 'Persona',
            'fields' => [
                'dni' => Type::string(),
                'nombres' => [
                    'type' => Type::string(),
                    'description' => 'Nombres Completos',
                ],
                'apellidoPaterno' => [
                    'type' => Type::string(),
                    'description' => 'Apellido Paterno',
                ],
                'apellidoMaterno' => [
                    'type' => Type::string(),
                    'description' => 'Apellido Materno',
                ],
                'codVerifica' => [
                    'type' => Type::string(),
                    'description' => 'Código de verificación',
                ],
            ],
        ];

        parent::__construct($config);
    }
}
