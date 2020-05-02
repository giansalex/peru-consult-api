<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Kernel extends \App\Kernel
{
    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MASTER_REQUEST, bool $catch = true)
    {
        $this->boot();
        $loop = $this->getContainer()->get('reactphp.event_loop');
        $promise = $this->handleAsync($request);
        $response = null;
        $promise->then(function ($result) use (&$response) {
            $response = $result;
        });
        $loop->run();

        return $response;
    }
}
