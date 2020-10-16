<?php

declare(strict_types=1);

namespace App\Controller;

use Peru\Sunat\UserValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserSolController
{
    /**
     * @var UserValidator
     */
    private $service;

    /**
     * UserSolController constructor.
     *
     * @param UserValidator $service
     */
    public function __construct(UserValidator $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $ruc
     * @param string $user
     *
     * @return JsonResponse
     */
    public function index($ruc, $user)
    {
        $user = strtoupper($user);

        $valid = $this->service->valid($ruc, $user);

        return new JsonResponse($valid);
    }

}