<?php

declare(strict_types=1);

namespace Peru\Api\Resolver;

use Peru\Services\DniInterface;

class DniResolver
{
    /**
     * @var DniInterface
     */
    private $service;

    public function __construct(DniInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke($root, $args)
    {
        return $this->service->get($args['dni']);
    }
}