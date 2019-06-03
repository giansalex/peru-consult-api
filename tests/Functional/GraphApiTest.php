<?php


namespace Tests\Functional;

use Peru\Sunat\Company;

class GraphApiTest extends BaseTestCase
{
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

        $response = $this->runApp('POST', '/api/graph', ['query' => $q]);

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