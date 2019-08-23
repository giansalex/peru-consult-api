<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Peru\Api\Controller;

use Peru\Api\Http\AppResponse;
use Peru\Api\Service\{DniMultiple, RucMultiple};
use Psr\Container\ContainerInterface;
use Slim\Http\{Request, Response};

class ConsultMultipleController
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
        $rucs = $request->getParsedBody();
        if (!is_array($rucs)) {
            return $response->withStatus(400);
        }

        $service = $this->container->get(RucMultiple::class);
        $promise = $service->get($rucs)
            ->then(function ($companies) use ($response) {
                return $response->withJson($companies);
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
    public function dni($request, $response, array $args)
    {
        $dnis = $request->getParsedBody();
        if (!is_array($dnis)) {
            return $response->withStatus(400);
        }

        $service = $this->container->get(DniMultiple::class);
        $promise = $service->get($dnis)
            ->then(function ($persons) use ($response) {
                return $response->withJson($persons);
            });

        return (new AppResponse())->withPromise($promise);
    }
}
