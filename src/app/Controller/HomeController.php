<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/12/2017
 * Time: 20:53
 */

namespace Peru\Api\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class HomeController
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index($request, $response, array $args)
    {
        /**@var $uri \Slim\Http\Uri */
        $uri = $request->getUri();
        /**@var $router \Slim\Router */
        $router = $this->container->get('router');
        /**@var $renderer PhpRenderer*/
        $renderer = $this->container->get('renderer');

        return $renderer->render($response, 'index.phtml', [
            'url' => $uri->getBasePath(),
            'json' => $router->pathFor('swagger')
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function swagger($request, $response, array $args)
    {
        $filename = $this->container->get('settings')['swagger_path'];
        if (!file_exists($filename)) {
            return $response->withStatus(404);
        }

        $uri = $request->getUri();
        $url = $uri->getHost();
        if ($uri->getPort() && $uri->getPort() !== 80) {
            $url .= ':' . $uri->getPort();
        }
        /**@var $uri \Slim\Http\Uri */
        $url .= $uri->getBasePath();

        $jsonContent = file_get_contents($filename);
        $response->getBody()->write(str_replace('consult.api', $url, $jsonContent));

        return $response->withHeader('Content-Type', 'application/json; charset=utf8');
    }
}