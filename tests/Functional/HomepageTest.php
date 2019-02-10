<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'API Consult'.
     */
    public function testGetHomepage()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('API Consult', (string)$response->getBody());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }

    /**
     * Test that the swagger route returns a json response
     */
    public function testGetSwaggerpage()
    {
        $response = $this->runApp('GET', '/swagger');

        $this->assertEquals(200, $response->getStatusCode());
        $obj = json_decode((string)$response->getBody());
        $this->assertEquals(0, json_last_error());
        $this->assertTrue(isset($obj->openapi));
        $this->assertTrue(isset($obj->servers));
        $this->assertTrue(isset($obj->paths));
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostSwaggerpageNotAllowed()
    {
        $response = $this->runApp('POST', '/swagger');

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}