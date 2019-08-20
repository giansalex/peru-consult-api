<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 20:53.
 */
declare(strict_types=1);

namespace Peru\Api\Controller;

use Peru\Api\Http\AppResponse;
use Peru\Jne\Async\Dni;
use Peru\Reniec\Person;
use Peru\Sunat\Async\Ruc;
use Peru\Sunat\Company;
use Peru\Sunat\UserValidator;
use Psr\Container\ContainerInterface;
use Slim\Http\{Request, Response};

class ConsultController
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function ruc($request, $response, array $args)
    {
        $ruc = $args['ruc'];
        $service = $this->container->get(Ruc::class);
        $promise = $service->get($ruc)
            ->then(function (?Company $company) use ($response) {
                if (!$company) {
                    return $response->withStatus(400);
                }

                return $response->withJson($company);
            });

        return (new AppResponse())->withPromise($promise);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function userSol($request, $response, array $args)
    {
        $ruc = $args['ruc'];
        $user = strtoupper($args['user']);

        $service = $this->container->get(UserValidator::class);
        $valid = $service->valid($ruc, $user);

        return $response->withJson($valid);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function dni($request, $response, array $args)
    {
        $dni = $args['dni'];
        $service = $this->container->get(Dni::class);
        $promise = $service->get($dni)
            ->then(function (?Person $person) use ($response) {
                if (!$person) {
                    return $response->withStatus(400);
                }

                return $response->withJson($person);
            });

        return (new AppResponse())->withPromise($promise);
    }
}
