<?php

declare(strict_types=1);

namespace Peru\Api\Resolver;

use Peru\Sunat\Ruc;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class RucResolver
{
    /**
     * @var Ruc
     */
    private $service;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Ruc $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;
    }

    public function __invoke($root, $args)
    {
        $company = $this->service->get($args['ruc']);
        if ($company === false) {
            $this->logger->error($this->service->getError());

            return null;
        }

        return $company;
    }
}