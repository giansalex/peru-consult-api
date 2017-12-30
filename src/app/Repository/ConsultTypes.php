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
            'description' => 'Persona',
            'fields' => [
                'dni' => Type::string(),
                'nombres' => Type::string(),
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
            // using defaultFieldResolver
        ]);
    }

    private function Company()
    {
        return new ObjectType([
            'name' => 'Company',
            'description' => 'Empresa',
            'fields' => [
                'ruc' => Type::string(),
                'razonSocial' => [
                    'type' => Type::string(),
                    'description' => 'Razón Social',
                ],
                'nombreComercial' => [
                    'type' => Type::string(),
                    'description' => 'Nombre Comercial',
                ],
                'telefonos' => Type::listOf(Type::string()),
                'tipo' => [
                    'type' => Type::string(),
                    'description' => 'Tipo Contribuyente',
                ],
                'estado' => Type::string(),
                'condicion' => Type::string(),
                'direccion' => Type::string(),
                'fechaInscripcion' => Type::string(),
                'sistEmsion' => [
                    'type' => Type::string(),
                    'description' => 'Sistema de Emisión de Comprobante',
                ],
                'sistContabilidad' => [
                    'type' => Type::string(),
                    'description' => 'Sistema de contabilidad',
                ],
                'actExterior' => [
                    'type' => Type::string(),
                    'description' => 'Actividad de Comercio Exterior',
                ],
                'actEconomicas' =>[
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Actividad(es) Económica(s)',
                ],
                'cpPago' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Comprobantes de Pago c/aut. de impresión (F. 806 u 816)',
                ],
                'sistElectronica' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Sistema de Emisión Electrónica',
                ],
                'fechaEmisorFe' => [
                    'type' => Type::string(),
                    'description' => 'Fecha inicio como Emisor electrónico',
                ],
                'cpeElectronico' => [
                    'type' => Type::listOf(Type::string()),
                    'description' => 'Comprobantes Electrónicos',
                ],
                'fechaPle' => [
                    'type' => Type::string(),
                    'description' => 'Fecha desde que esta afiliado al PLE',
                ],
                'padrones' => Type::listOf(Type::string()),
            ],
        ]);
    }
}