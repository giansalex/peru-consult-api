<?php

declare(strict_types=1);

namespace App\Controller;

use Peru\Jne\Async\Dni;
use Peru\Reniec\Person;
use Peru\Sunat\Async\Ruc;
use Peru\Sunat\Company;
use Peru\Sunat\UserValidator;
use Psr\Container\ContainerInterface;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConsultController
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
     * @param string $ruc
     *
     * @return PromiseInterface
     */
    public function ruc($ruc)
    {
        $service = $this->container->get(Ruc::class);

        return $service->get($ruc)
            ->then(function (?Company $company) {
                if (!$company) {
                    throw new BadRequestHttpException();
                }

                return new JsonResponse($company);
            });
    }

    /**
     * @param string $ruc
     * @param string $user
     *
     * @return JsonResponse
     */
    public function userSol($ruc, $user)
    {
        $user = strtoupper($user);

        $service = $this->container->get(UserValidator::class);
        $valid = $service->valid($ruc, $user);

        return new JsonResponse($valid);
    }

    /**
     * @param string $dni
     *
     * @return PromiseInterface
     */
    public function dni($dni)
    {
        $service = $this->container->get(Dni::class);

        return $service->get($dni)
            ->then(function (?Person $person) {
                if (!$person) {
                    throw new BadRequestHttpException();
                }

                return new JsonResponse($person);
            });
    }
}
