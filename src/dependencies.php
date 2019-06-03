<?php

// DIC configuration

use GraphQL\Type\Schema;
use Peru\Api\Controller\GraphController;
use Peru\Api\Repository\CompanyType;
use Peru\Api\Repository\PersonType;
use Peru\Api\Repository\RootType;
use Peru\Api\Service\ArrayConverter;
use Peru\Api\Service\DniMultiple;
use Peru\Api\Service\GraphRunner;
use Peru\Api\Service\RucMultiple;
use Peru\Http\ClientInterface;
use Peru\Http\ContextClient;
use Peru\Jne\Dni;
use Peru\Sunat\Ruc;
use Peru\Sunat\UserValidator;

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

$container[ClientInterface::class] = function () {
    return new ContextClient();
};

$container[Ruc::class] = function ($c) {
    $cs = new Ruc();
    $cs->setClient($c->get(ClientInterface::class));

    return $cs;
};

$container[Dni::class] = function ($c) {
    $cs = new Dni();
    $cs->setClient($c->get(ClientInterface::class));

    return $cs;
};

$container[UserValidator::class] = function ($c) {
    return new UserValidator($c->get(ClientInterface::class));
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

$container[PersonType::class] = function () {
    return new PersonType();
};

$container[CompanyType::class] = function () {
    return new CompanyType();
};

$container[RootType::class] = function ($c) {
    return new RootType($c);
};

$container[Schema::class] = function ($c) {
    return new Schema([
        'query' => $c->get(RootType::class),
    ]);
};

$container[GraphRunner::class] = function ($c) {
    return new GraphRunner($c->get(Schema::class), $c->get('logger'));
};

$container[GraphController::class] = function ($c) {
    return new GraphController($c->get(GraphRunner::class));
};

$container['errorHandler'] = function ($container) {
    $showErrors = $container->get('settings')['displayErrorDetails'];
    if ($showErrors) {
        return new Slim\Handlers\Error(true);
    }

    return new \Peru\Api\Handler\CustomError();
};
