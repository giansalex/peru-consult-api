<?php

declare(strict_types=1);

namespace Peru\Api\Resolver;

use Peru\Jne\Dni;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class DniResolver
{
    /**
     * @var Dni
     */
    private $service;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Dni $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
    }

    public function __invoke($root, $args)
    {
        $person = $this->service->get($args['dni']);
        if ($person === false) {
            $this->logger->error($this->service->getError());
            return null;
        }

        return $person;
    }
}