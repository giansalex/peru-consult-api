<?php

$dir = __DIR__;
require $dir.'/../vendor/autoload.php';

$settings = require $dir.'/../src/settings.php';
$app = new \Slim\App($settings);

require $dir.'/../src/dependencies.php';
require $dir.'/../src/middleware.php';
require $dir.'/../src/routes.php';

// Run app
$app->run();
