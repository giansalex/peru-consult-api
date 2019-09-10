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
        $response = $this->runApp('GET', '/api/v1/ruc/20550263948');

        $this->assertEquals(200, $response->getStatusCode());

        /**@var $company Company */
        $company = json_decode((string)$response->getBody());

        $this->assertContains('SOCIEDAD COMERCIAL', $company->razonSocial);
        $this->assertEquals('HABIDO', $company->condicion);
        $this->assertEquals('BAJA DE OFICIO', $company->estado);
    }

    public function testConsult()
    {
        $response = $this->runApp('GET', '/api/v1/dni/123456788');
        $this->assertEquals(404, $response->getStatusCode());
    }
    public function testConsultDni()
    {
        $response = $this->runApp('GET', '/api/v1/dni/48004836');

        $this->assertEquals(200, $response->getStatusCode());
        /**@var $person Person*/
        $person = json_decode((string)$response->getBody());
        $this->assertEquals('ROBERTO CARLOS', $person->nombres);
    }

    public function testConsultUserSol()
    {
        $response = $this->runApp('GET', '/api/v1/user-sol/20000000001/HUAFDSMU');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(in_array((string)$response->getBody(), ['true', 'false']));
    }
}