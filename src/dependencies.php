<?php

// DIC configuration

use GraphQL\Type\Schema;
use Peru\Api\Controller\GraphController;
use Peru\Api\Handler\CustomError;
use Peru\Api\Repository\{CompanyType, PersonType, RootType};
use Peru\Api\Resolver\{DniResolver, RucResolver};
use Peru\Api\Service\{ArrayConverter, DniMultiple, GraphRunner, RucMultiple};
use Peru\Http\{Async\HttpClient, ClientInterface, ContextClient, EmptyResponseDecorator};
use Peru\Jne\{Dni, DniParser};
use Peru\Services\{DniInterface, RucInterface};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};
use Peru\Sunat\UserValidator;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

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
    return new EmptyResponseDecorator(new ContextClient());
};

$container[RucInterface::class] = function ($c) {
    return new Ruc($c->get(ClientInterface::class), new RucParser(new HtmlParser()));
};

$container[DniInterface::class] = function ($c) {
    return new Dni($c->get(ClientInterface::class), new DniParser());
};

$container[UserValidator::class] = function ($c) {
    return new UserValidator($c->get(ClientInterface::class));
};

$container[RucMultiple::class] = function ($c) {
    return new RucMultiple($c->get(RucInterface::class));
};

$container[DniMultiple::class] = function ($c) {
    return new DniMultiple($c->get(DniInterface::class));
};

$container[ArrayConverter::class] = function () {
    return new ArrayConverter();
};

$container[DniResolver::class] = function ($c) {
    return new DniResolver($c->get(DniInterface::class));
};

$container[RucResolver::class] = function ($c) {
    return new RucResolver($c->get(RucInterface::class));
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

    return new CustomError();
};

$container[LoopInterface::class] = function () {
    return Factory::create();
};

$container[\Peru\Http\Async\ClientInterface::class] = function ($c) {
    return new HttpClient($c->get(LoopInterface::class));
};

$container[\Peru\Sunat\Async\Ruc::class] = function ($c) {
    return new \Peru\Sunat\Async\Ruc($c->get(\Peru\Http\Async\ClientInterface::class), new RucParser(new HtmlParser()));
};

$container[\Peru\Jne\Async\Dni::class] = function ($c) {
    return new \Peru\Jne\Async\Dni($c->get(\Peru\Http\Async\ClientInterface::class), new DniParser());
};