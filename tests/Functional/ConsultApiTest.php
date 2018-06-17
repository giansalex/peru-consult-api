<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 12/12/2017
 * Time: 21:14
 */

namespace Tests\Functional;

use Peru\Reniec\Person;
use Peru\Sunat\Company;

class ConsultApiTest extends BaseTestCase
{
    public function testConsultRucInvalid()
    {
        $response = $this->runApp('GET', '/api/v1/ruc/12312');

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testConsultRuc()
    {
        $response = $this->runApp('GET', '/api/v1/ruc/20131312955');

        $this->assertEquals(200, $response->getStatusCode());

        /**@var $company Company */
        $company = json_decode((string)$response->getBody());

        $this->assertContains('SUPERINTENDENCIA NACIONAL', $company->razonSocial);
        $this->assertEquals('HABIDO', $company->condicion);
        $this->assertEquals('ACTIVO', $company->estado);
    }

    public function testConsultGraph()
    {
        $q = <<<QL
query { 
    company(ruc: "20131312955") {
        ruc
        razonSocial
        nombreComercial
        telefonos
        tipo
        estado
        condicion
        direccion
        departamento
        provincia
        distrito
        fechaInscripcion
        sistEmsion
        sistContabilidad
        actExterior
        actEconomicas
        cpPago
        sistElectronica
        fechaEmisorFe
        cpeElectronico
        fechaPle
        padrones
    }
}

QL;

        $response = $this->runApp('POST', '/api/v1/graph', ['query' => $q]);

        $this->assertEquals(200, $response->getStatusCode());
        $obj = json_decode((string)$response->getBody());

        /**@var $company Company */
        $company = $obj->data->company;

        $this->assertFalse(isset($obj->errors));
        $this->assertContains('SUPERINTENDENCIA NACIONAL', $company->razonSocial);
        $this->assertEquals('HABIDO', $company->condicion);
        $this->assertEquals('ACTIVO', $company->estado);
        $this->assertNotEmpty($company->direccion);
        $this->assertNotEmpty($company->departamento);
        $this->assertNotEmpty($company->provincia);
        $this->assertNotEmpty($company->distrito);
        $this->assertNotEmpty($company->fechaInscripcion);
    }

    public function testConsultUserSol()
    {
        $response = $this->runApp('GET', '/api/v1/user-sol/20123456789/ABC1245');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(in_array((string)$response->getBody(), ['true', 'false']));
    }
}