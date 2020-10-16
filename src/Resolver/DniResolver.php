<?php

declare(strict_types=1);

namespace App\Resolver;

use Peru\Jne\Async\Dni;
use React\Promise\PromiseInterface;

class DniResolver
{
    /**
     * @var Dni
     */
    private $service;

    public function __construct(Dni $service)
    {
        $this->service = $service;
    }

    public function __invoke($root, $args): PromiseInterface
    {
        return $this->service->get($args['dni']);
    }
}
