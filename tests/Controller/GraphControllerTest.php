<?php

declare(strict_types=1);

namespace Tests\Functional;

use Peru\Reniec\Person;
use Peru\Sunat\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GraphControllerTest extends WebTestCase
{
    public function testConsultGraph()
    {
        $q = <<<QL
query { 
    company(ruc: "20493919271") {
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
        fechaBaja
        profesion
    }
    person(dni: "48004836") {
        dni
        nombres
    }
}

QL;
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/graph?token=abcxyz',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['query' => $q])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $obj = json_decode($client->getResponse()->getContent());

        /** @var $company Company */
        $company = $obj->data->company;
        /** @var $person Person */
        $person = $obj->data->person;

        $this->assertFalse(isset($obj->errors));
        $this->assertStringContainsString('EMPRESA CONSTRUCTORA', $company->razonSocial);
        $this->assertEquals('NO HABIDO', $company->condicion);
        $this->assertEquals('SUSPENSION TEMPORAL', $company->estado);
        $this->assertNotEmpty($company->direccion);
        $this->assertNotEmpty($company->departamento);
        $this->assertNotEmpty($company->provincia);
        $this->assertNotEmpty($company->distrito);
        $this->assertNotEmpty($company->fechaInscripcion);
        $this->assertNotEmpty($person->dni);
        $this->assertNotEmpty($person->nombres);
        $this->assertStringContainsString('NOMBRES', $person->nombres);
    }
}
