<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 03/02/2018
 * Time: 14:38.
 */

namespace Peru\Api\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class TokenMiddleware
{
    /**
     * @var string
     */
    private $token;

    /**
     * TokenMiddleware constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Auth middleware invokable class.
     *
     * @param Request  $request  PSR7 request
     * @param Response $response PSR7 response
     * @param callable $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $token = $request->getQueryParam('token');

        if ($token !== $this->token) {
            return $response->withJson(['message' => 'Token Inválido'], 401);
        }

        $response = $next($request, $response);

        return $response;
    }
}
