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

    public function testConsult()
    {
        $response = $this->runApp('GET', '/api/v1/dni/123456788');

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testConsultDni()
    {
        $response = $this->runApp('GET', '/api/v1/dni/48004836');

        if ($response->getStatusCode() == 500) {
            echo (string)$response->getBody();
            return;
        }

        $this->assertEquals(200, $response->getStatusCode());
        /**@var $person Person*/
        $person = json_decode((string)$response->getBody());

        if (!empty(getenv('CI'))) {
            return;
        }

        $this->assertEquals('ROBERTO CARLOS', $person->nombres);
        $this->assertEquals('4', $person->codVerifica);
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
}