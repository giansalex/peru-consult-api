<?php

// DIC configuration

use Peru\Api\Repository\ConsultTypes;
use Peru\Api\Service\ArrayConverter;
use Peru\Api\Service\DniMultiple;
use Peru\Api\Service\GraphRunner;
use Peru\Api\Service\RucMultiple;
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
    $logger = new Katzgrau\KLogger\Logger($settings['path'], $settings['level'], ['extension' => 'log']);

    return $logger;
};

$container[Ruc::class] = function () {
    return new Ruc();
};

$container[Dni::class] = function () {
    return new Dni();
};

$container[RucMultiple::class] = function ($c) {
    return new RucMultiple($c->get(Ruc::class));
};

$container[DniMultiple::class] = function ($c) {
    return new DniMultiple($c->get(Dni::class));
};

$container[ArrayConverter::class] = function () {
    return new ArrayConverter();
};

$container[ConsultTypes::class] = function () {
    return new ConsultTypes();
};

$container[GraphRunner::class] = function ($c) {
    return new GraphRunner($c);
};
