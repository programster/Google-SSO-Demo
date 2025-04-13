<?php

use Slim\Psr7\Factory\ResponseFactory;

class SlimLib
{
    public static function createJsonResponse(array $responseData) : \Slim\Psr7\Response
    {
        $responseBody = json_encode($responseData);
        $response = new \Slim\Psr7\Response($status = 200);
        $response->getBody()->write($responseBody);
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public static function createRedirectResponse(string $newLocation, int $httpCode=302) : \Psr\Http\Message\ResponseInterface
    {
        $response = new \Slim\Psr7\Response()->withStatus($httpCode);
        return $response->withHeader('Location', $newLocation);
    }
}