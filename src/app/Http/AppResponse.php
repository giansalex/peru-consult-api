<?php

namespace Peru\Api\Http;

use React\Promise\PromiseInterface;
use Slim\Http\Response;

class AppResponse extends Response
{
    /**
     * @var PromiseInterface
     */
    private $promise;

    public function withPromise(PromiseInterface $promise)
    {
        $clone = clone $this;
        $clone->promise = $promise;

        return $clone;
    }

    /**
     * @return PromiseInterface
     */
    public function getPromise(): PromiseInterface
    {
        return $this->promise;
    }
}