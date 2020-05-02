<?php declare(strict_types=1);

namespace App\Tests\Controller;

use Peru\Reniec\Person;
use Peru\Sunat\Company;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConsultControllerTest extends WebTestCase
{
    public function testConsultRuc()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/ruc/20550263948?token=abcxyz');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /**@var $company Company */
        $company = json_decode($client->getResponse()->getContent());

        $this->assertStringContainsString('SOCIEDAD COMERCIAL', $company->razonSocial);
        $this->assertEquals('HABIDO', $company->condicion);
        $this->assertEquals('BAJA DE OFICIO', $company->estado);
    }

    public function testConsultDni()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/dni/48004836?token=abcxyz');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        /**@var $person Person*/
        $person = json_decode($client->getResponse()->getContent());
        $this->assertEquals('NOMBRES', $person->nombres);
    }

    public function testConsultUserSol()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/user-sol/20000000001/HUAFDSMU?token=abcxyz');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(in_array($client->getResponse()->getContent(), ['true', 'false']));
    }
}