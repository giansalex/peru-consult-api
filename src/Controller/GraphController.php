<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GraphRunner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GraphController extends AbstractController
{
    /**
     * @var GraphRunner
     */
    private $graph;

    /**
     * GraphController constructor.
     */
    public function __construct(GraphRunner $graph)
    {
        $this->graph = $graph;
    }

    /**
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function query(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['query'])) {
            throw new BadRequestHttpException();
        }

        $result = $this->graph->execute($data['query'], isset($data['variables']) ? $data['variables'] : null);

        return $this->json($result);
    }
}
