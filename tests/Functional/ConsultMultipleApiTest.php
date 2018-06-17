<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:34
 */

namespace Tests\Functional;


use Peru\Reniec\Person;
use Peru\Sunat\Company;

class ConsultMultipleApiTest extends BaseTestCase
{
    public function testConsultRucNotAllowed()
    {
        $response = $this->runApp('GET', '/api/v1/ruc');

        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testConsultRucInvalid()
    {
        $response = $this->runApp('POST', '/api/v1/ruc');

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testConsultRuc()
    {
        $arr = ['20101266819', '20508316985', '20537979381'];
        $response = $this->runApp('POST', '/api/v1/ruc', $arr);

        $this->assertEquals(200, $response->getStatusCode());

        /**@var $companies Company[] */
        $companies = json_decode((string)$response->getBody());

        $this->assertEquals(3, count($companies));

        foreach ($companies as $company) {
            $this->assertTrue(in_array($company->ruc, $arr));
            $this->assertNotEmpty($company->razonSocial);
        }
    }
}