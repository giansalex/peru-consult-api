<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 20:53
 */

namespace Peru\Api\Controller;

use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ConsultController
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function ruc($request, $response, array $args)
    {
        $ruc = $args['ruc'];
        /**@var $service Ruc */
        $service = $this->container->get(Ruc::class);
        $company = $service->get($ruc);
        if ($company === false) {
            $this->getLogger()->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($company));
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function dni($request, $response, array $args)
    {
        $dni = $args['dni'];
        /**@var $service Dni */
        $service = $this->container->get(Dni::class);
        $person = $service->get($dni);
        if ($person === false) {
            $this->getLogger()->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($person));
    }

    /**
     * @return LoggerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getLogger()
    {
        return $this->container->get('logger');
    }
}