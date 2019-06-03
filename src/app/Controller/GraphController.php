<?php

namespace Peru\Api\Controller;

use Peru\Api\Service\GraphRunner;
use Slim\Http\Request;
use Slim\Http\Response;

class GraphController
{
    /**
     * @var GraphRunner
     */
    private $graph;

    /**
     * GraphController constructor.
     *
     * @param GraphRunner $graph
     */
    public function __construct(GraphRunner $graph)
    {
        $this->graph = $graph;
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
     * @throws \Throwable
     */
    public function query($request, $response, array $args)
    {
        $data = $request->getParsedBody();
        if (!isset($data['query'])) {
            return $response->withStatus(400);
        }

        $result = $this->graph->execute($data['query'], isset($data['variables']) ? $data['variables'] : null);

        return $response->withJson($result);
    }
}
