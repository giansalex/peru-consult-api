<?php

declare(strict_types=1);

namespace App\Resolver;

use Peru\Services\RucInterface;

class RucResolver
{
    /**
     * @var RucInterface
     */
    private $service;

    public function __construct(RucInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke($root, $args)
    {
        return $this->service->get($args['ruc']);
    }
}
