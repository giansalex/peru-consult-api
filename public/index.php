<?php

$dir = __DIR__;
require $dir.'/../vendor/autoload.php';

$settings = require $dir.'/../src/settings.php';
$app = new \Slim\App($settings);

require $dir.'/../src/dependencies.php';
require $dir.'/../src/middleware.php';
require $dir.'/../src/routes.php';

// Run app
$response = $app->run(true);

if ($response instanceof \Peru\Api\Http\AppResponse) {
    promiseProcess($response);
    return;
}

$app->respond($response);

function promiseProcess(\Peru\Api\Http\AppResponse $response)
{
    global $app;
    $container = $app->getContainer();
    $response->getPromise()
        ->then(function ($response) use ($app) {
            $app->respond($response);
        }, function (Exception $e) use ($container, $app) {
            if ($container['settings']['displayErrorDetails']) {
                var_dump($e);
                return;
            }

            $container->get('logger')->error($e->getMessage());
            $app->respond((new \Slim\Http\Response(500))
                ->withJson(['message' => 'Ocurrio un error.']));
        });
    $container->get(\React\EventLoop\LoopInterface::class)->run();
}