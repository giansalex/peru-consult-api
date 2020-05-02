<?php

declare(strict_types=1);

namespace App\Tests\Stub;

use Peru\Http\Async\ClientInterface;
use React\Promise\PromiseInterface;

class HttpClientStub implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * HttpClientStub constructor.
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Make GET Request.
     *
     * @return PromiseInterface
     */
    public function getAsync(string $url, array $headers = []): PromiseInterface
    {
        return $this->client->getAsync(ClientStubDecorator::getNewUrl($url), $headers);
    }

    /**
     * Post Request.
     *
     * @param mixed $data
     *
     * @return PromiseInterface
     */
    public function postAsync(string $url, $data, array $headers = []): PromiseInterface
    {
        return $this->client->postAsync(ClientStubDecorator::getNewUrl($url), $data, $headers);
    }
}
