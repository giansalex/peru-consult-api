<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 13/02/2019
 * Time: 11:40
 */

declare(strict_types=1);

namespace Peru\Api\Handler;

use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Slim\Handlers\AbstractError;

class CustomError extends AbstractError
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception) {

        $contentType = $this->determineContentType($request);
        $output = 'API Error';
        switch ($contentType) {
            case 'application/json':
                $output = '{"message":"'.$output.'"}';
                break;

            case 'text/xml':
            case 'application/xml':
                $output = "<error>\n  <message>$output</message>\n";
                break;
        }

        $this->writeToErrorLog($exception);

        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', $contentType)
            ->write($output);
    }
}