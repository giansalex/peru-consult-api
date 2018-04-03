<?php

$container = $app->getContainer();

// Routes
$app->group('/api/v1', function () {
    /* @var $this Slim\App */
    $this->get('/ruc/{ruc:\d{11}}', 'Peru\Api\Controller\ConsultController:ruc');
    $this->get('/dni/{dni:\d{8}}', 'Peru\Api\Controller\ConsultController:dni');
    $this->post('/ruc', 'Peru\Api\Controller\ConsultMultipleController:ruc');
    $this->post('/dni', 'Peru\Api\Controller\ConsultMultipleController:dni');
    $this->get('/user-sol/{ruc}/{user}', 'Peru\Api\Controller\ConsultController:userSol');
    $this->post('/graph', 'Peru\Api\Controller\ConsultController:graph');
})->add(new \Peru\Api\Middleware\TokenMiddleware($container['settings']['auth']['token']));

$app->get('/', 'Peru\Api\Controller\HomeController:index');

$app->get('/swagger', 'Peru\Api\Controller\HomeController:swagger')->setName('swagger');
