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

    public function process(App $app, AppResponse $appResponse)
    {
        $appResponse->getPromise()
            ->then(function ($response) use ($appResponse, $app) {
                $app->respond($this->fromCopyHeaders($appResponse, $response));
            }, function (Exception $e) use ($app) {
                $this->container->get('errorHandler')($this->container->get('request'), new Response(500), $e);
            });

        $this->container->get(LoopInterface::class)
            ->run();
    }

    private function fromCopyHeaders(Response $source, Response $target)
    {
        foreach ($source->getHeaders() as $header => $value) {
            $target = $target->withHeader($header, $value);
        }

        return $target;
    }
}
