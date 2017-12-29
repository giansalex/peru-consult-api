<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/12/2017
 * Time: 12:57 PM
 */

namespace Peru\Api\Repository;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ConsultTypes
{
    private $types = [];

    public function get($name)
    {
        if (!isset($this->types[$name])) {
            $this->types[$name] = $this->{$name}();
        }
        return $this->types[$name];
    }

    private function Person()
    {
        return new ObjectType([
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
    }

    private function Company()
    {
        return new ObjectType([
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
    }
}