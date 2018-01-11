<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/12/2017
 * Time: 09:57 AM
 */

namespace Peru\Api\Repository;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CompanyType extends ObjectType
{

    /**
     * CompanyType constructor.
     */
    public function __construct()
    {
        $config = [
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
                'departamento' => Type::string(),
                'provincia' => Type::string(),
                'distrito' => Type::string(),
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
        ];

        parent::__construct($config);
    }
}