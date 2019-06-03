<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Peru\Api\Controller;

use Peru\Api\Service\ArrayConverter;
use Peru\Api\Service\DniMultiple;
use Peru\Api\Service\RucMultiple;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

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
        /** @var $service RucMultiple */
        $service = $this->container->get(RucMultiple::class);
        $companies = $service->get($rucs);

        return $response->withJson($this->container->get(ArrayConverter::class)->convert($companies));
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
        /** @var $service DniMultiple */
        $service = $this->container->get(DniMultiple::class);
        $persons = $service->get($dnis);

        return $response->withJson($this->container->get(ArrayConverter::class)->convert($persons));
    }
}
