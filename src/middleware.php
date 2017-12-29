<?php

// Application middleware

// CORS
$app->add(new \Tuupola\Middleware\Cors([
    'origin' => ['*'],
    'methods' => ['GET', 'POST'],
    'headers.allow' => ['Authorization', 'Accept', 'Content-Type'],
    'headers.expose' => [],
    'credentials' => false,
    'cache' => 0,
]));
