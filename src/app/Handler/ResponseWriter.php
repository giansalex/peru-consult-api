<?php

namespace Peru\Api\Handler;

use Exception;
use Peru\Api\Http\AppResponse;
use Psr\Container\ContainerInterface;
use React\EventLoop\LoopInterface;
use Slim\App;
use Slim\Http\Response;

class ResponseWriter
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ResponseWriter constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(App $app, AppResponse $response)
    {
        $response->getPromise()
            ->then(function ($response) use ($app) {
                $app->respond($response);
            }, function (Exception $e) use ($app) {
                $this->container->get('errorHandler')($this->container->get('request'), new Response(500), $e);
            });

        $this->container->get(LoopInterface::class)
            ->run();
    }
}
