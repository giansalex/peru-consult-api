<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GraphRunner;
use React\Promise\PromiseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GraphController extends AbstractController
{
    /**
     * @var GraphRunner
     */
    private $graphql;

    /**
     * GraphController constructor.
     *
     * @param GraphRunner $graphql
     */
    public function __construct(GraphRunner $graphql)
    {
        $this->graphql = $graphql;
    }

    /**
     * @param Request $request
     *
     * @return PromiseInterface
     */
    public function query(Request $request): PromiseInterface
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['query'])) {
            throw new BadRequestHttpException();
        }

        return $this->graphql
            ->execute($data['query'], isset($data['variables']) ? $data['variables'] : null)
            ->then(function ($data) {
                return new JsonResponse($data);
            });
    }
}
