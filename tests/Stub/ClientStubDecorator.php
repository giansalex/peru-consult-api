<?php

declare(strict_types=1);

namespace App\Tests\Stub;

use Peru\Http\ClientInterface;

/**
 * Class ClientStubDecorator.
 *
 * Override base url with mock url.
 */
class ClientStubDecorator implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * ClientStubDecorator constructor.
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get Request.
     *
     * @return string|false
     */
    public function get(string $url, array $headers = [])
    {
        return $this->client->get(self::getNewUrl($url), $headers);
    }

    /**
     * Post Request.
     *
     * @param mixed $data
     *
     * @return string|false
     */
    public function post(string $url, $data, array $headers = [])
    {
        return $this->client->post(self::getNewUrl($url), $data, $headers);
    }

    public static function getNewUrl($url)
    {
        $urlBase = $_ENV['MOCK_URL'];
        if (empty($urlBase)) {
            return $url;
        }

        $u = parse_url($url);

        return $urlBase.$u['path'].(isset($u['query']) ? "?$u[query]" : '');
    }
}
