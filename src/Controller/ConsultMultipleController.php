<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\{DniMultiple, RucMultiple};
use Psr\Container\ContainerInterface;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConsultMultipleController
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultController constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return PromiseInterface
     */
    public function ruc(Request $request)
    {
        $rucs = json_decode($request->getContent());
        if (!is_array($rucs)) {
            throw new BadRequestHttpException();
        }

        $service = $this->container->get(RucMultiple::class);

        return $service->get($rucs)
            ->then(function ($companies) {
                return new JsonResponse($companies);
            });
    }

    /**
     * @return PromiseInterface
     */
    public function dni(Request $request)
    {
        $dnis = json_decode($request->getContent());
        if (!is_array($dnis)) {
            throw new BadRequestHttpException();
        }

        $service = $this->container->get(DniMultiple::class);

        return $service->get($dnis)
            ->then(function ($persons) {
                return new JsonResponse($persons);
            });
    }
}
