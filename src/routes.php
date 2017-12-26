<?php

use Peru\Reniec\Dni;
use Peru\Sunat\Ruc;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->group('/api/v1', function () {
    /**@var $this Slim\App */
    $this->get('/ruc/{ruc:\d{11}}', function (Request $request, Response $response, array $args) {
        $ruc = $args['ruc'];
        /**@var $service Ruc */
        $service = $this->get(Ruc::class);
        $company = $service->get($ruc);
        if ($company === false) {
            $this->logger->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($company));
    });

    $this->get('/dni/{dni:\d{8}}', function (Request $request, Response $response, array $args) {
        $dni = $args['dni'];
        /**@var $service Dni */
        $service = $this->get(Dni::class);
        $person = $service->get($dni);
        if ($person === false) {
            $this->logger->error($service->getError());
            $response->getBody()->write($service->getError());
            return $response->withStatus(500);
        }

        return $response->withJson(get_object_vars($person));
    });
});

$app->get('/', function (Request $request, Response $response, array $args) {
    /**@var $uri \Slim\Http\Uri */
    $uri = $request->getUri();
    /**@var $router \Slim\Router */
    $router = $this->router;

    return $this->renderer->render($response, 'index.phtml', [
    	'url' => $uri->getBasePath(),
    	'json' => $router->pathFor('swagger')
    ]);
});

$app->get('/swagger', function (Request $request, Response $response, array $args) {
    $filename = __DIR__ . '/../public/swagger.json';
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
})->setName('swagger');