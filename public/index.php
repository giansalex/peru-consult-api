<?php

use Peru\Api\Handler\ResponseWriter;
use Peru\Api\Http\AppResponse;

$dir = __DIR__;
require $dir.'/../vendor/autoload.php';

$settings = require $dir.'/../src/settings.php';
$app = new \Slim\App($settings);

require $dir.'/../src/dependencies.php';
require $dir.'/../src/middleware.php';
require $dir.'/../src/routes.php';

// Run app
$response = $app->run(true);

if ($response instanceof AppResponse) {
    $app->getContainer()->get(ResponseWriter::class)->process($app, $response);
    return;
}

$app->respond($response);