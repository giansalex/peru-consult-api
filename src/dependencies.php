<?php
// DIC configuration

use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger =  new Katzgrau\KLogger\Logger($settings['path'], $settings['level'], ['extension' => 'log']);
    return $logger;
};


$container[Ruc::class] = function () {
    return new Ruc();
};

$container[Dni::class] = function () {
    return new Dni();
};