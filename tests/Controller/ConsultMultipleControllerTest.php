<?php declare(strict_types=1);

namespace Tests\Functional;

use Peru\Reniec\Person;
use Peru\Sunat\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConsultMultipleControllerTest extends WebTestCase
{
    public function testConsultRuc()
    {
        $array = ['20440374248', '20550263948', '20493919271'];
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/ruc?token=abcxyz',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($array)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /**@var $companies Company[] */
        $companies = json_decode($client->getResponse()->getContent());

        $this->assertEquals(3, count($companies));

        foreach ($companies as $company) {
            $this->assertTrue(in_array($company->ruc, $array));
            $this->assertNotEmpty($company->razonSocial);
        }
    }

    public function testConsultDni()
    {
        $array = ['48004836'];
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/dni?token=abcxyz',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($array)
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        /**@var $persons Person[] */
        $persons = json_decode($client->getResponse()->getContent());
        $this->assertEquals(1, count($persons));
        foreach ($persons as $person) {
            $this->assertTrue(in_array($person->dni, $array));
            $this->assertNotEmpty($person->nombres);
        }
    }
}