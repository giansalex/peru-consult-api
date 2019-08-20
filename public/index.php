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
    $response->getPromise()->then(function ($response) use ($app) {
        $app->respond($response);
    });
    $app->getContainer()->get(\React\EventLoop\LoopInterface::class)->run();

    return;
}

$app->respond($response);