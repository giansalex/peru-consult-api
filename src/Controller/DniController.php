<?php

declare(strict_types=1);

namespace App\Controller;

use Peru\Jne\Async\Dni;
use Peru\Reniec\Person;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DniController
{
    /**
     * @var Dni
     */
    private $service;

    /**
     * DniController constructor.
     *
     * @param Dni $service
     */
    public function __construct(Dni $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $dni
     *
     * @return PromiseInterface
     */
    public function index($dni): PromiseInterface
    {
        return $this->service
            ->get($dni)
            ->then(function (?Person $person) {
                if (!$person) {
                    throw new BadRequestHttpException();
                }

                return new JsonResponse($person);
            });
    }
}