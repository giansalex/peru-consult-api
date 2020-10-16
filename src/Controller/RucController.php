<?php

declare(strict_types=1);

namespace App\Controller;

use Peru\Sunat\Async\Ruc;
use Peru\Sunat\Company;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RucController
{
    /**
     * @var Ruc
     */
    private $service;

    /**
     * RucController constructor.
     *
     * @param Ruc $service
     */
    public function __construct(Ruc $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $ruc
     *
     * @return PromiseInterface
     */
    public function ruc($ruc)
    {
        return $this->service
            ->get($ruc)
            ->then(function (?Company $company) {
                if (!$company) {
                    throw new BadRequestHttpException();
                }

                return new JsonResponse($company);
            });
    }
}