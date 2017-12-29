<?php

use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/api/v1', function () {
    /**@var $this Slim\App */
    $this->get('/ruc/{ruc:\d{11}}', 'Peru\Api\Controller\ConsultController:ruc');
    $this->get('/dni/{dni:\d{8}}', 'Peru\Api\Controller\ConsultController:dni');
    $this->post('/ruc', 'Peru\Api\Controller\ConsultMultipleController:ruc');
    $this->get('/dni', 'Peru\Api\Controller\ConsultMultipleController:dni');
});

$app->get('/', 'Peru\Api\Controller\HomeController:index');

$app->get('/swagger', 'Peru\Api\Controller\HomeController:swagger')->setName('swagger');