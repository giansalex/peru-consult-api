<?php

declare(strict_types=1);

namespace App\Resolver;

use Peru\Sunat\Async\Ruc;
use React\Promise\PromiseInterface;

class RucResolver
{
    /**
     * @var Ruc
     */
    private $service;

    public function __construct(Ruc $service)
    {
        $this->service = $service;
    }

    public function __invoke($root, $args): PromiseInterface
    {
        return $this->service->get($args['ruc']);
    }
}
