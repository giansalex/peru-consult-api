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
            'token' => getenv('API_TOKEN'),
        ],

        'swagger_path' => __DIR__.'/../public/swagger.json',

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => 'logs',
            'level' => Psr\Log\LogLevel::INFO,
        ],
    ],
];
