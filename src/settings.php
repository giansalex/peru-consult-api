<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__.'/../templates/',
        ],

        'auth' => [
            'token' => 'abcxyz'
        ],

        'swagger_path' => __DIR__.'/../public/openapi.json',

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__.'/../logs',
            'level' => Psr\Log\LogLevel::DEBUG,
        ],
    ],
];
