<?php

use Peru\Api\Middleware\TokenMiddleware;

$container = $app->getContainer();
$auth = new TokenMiddleware($container['settings']['auth']['token']);

// Routes
$app->group('/api', function () {
    /* @var $this Slim\App */
    $this->group('/v1', function () {
        $this->get('/ruc/{ruc:\d{11}}', 'Peru\Api\Controller\ConsultController:ruc');
        $this->get('/dni/{dni:\d{8}}', 'Peru\Api\Controller\ConsultController:dni');
        $this->post('/ruc', 'Peru\Api\Controller\ConsultMultipleController:ruc');
        $this->post('/dni', 'Peru\Api\Controller\ConsultMultipleController:dni');
        $this->get('/user-sol/{ruc}/{user}', 'Peru\Api\Controller\ConsultController:userSol');
    });
    $this->post('/graph', 'Peru\Api\Controller\GraphController:query');

})->add($auth);

$app->get('/', 'Peru\Api\Controller\HomeController:index');
$app->get('/swagger', 'Peru\Api\Controller\HomeController:swagger')->setName('swagger');
