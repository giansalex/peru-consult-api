<?php

return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],

        'auth' => [
            'token' => isset($_ENV['API_TOKEN']) ? getenv('API_TOKEN') : '',
        ],

        'swagger_path' => __DIR__.'/../public/openapi.json',

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => 'php://stdout',
            'level' => Psr\Log\LogLevel::INFO,
        ],
    ],
];
