<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController
{
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'app' => 'Peru Consult API'
        ]);
    }
}
