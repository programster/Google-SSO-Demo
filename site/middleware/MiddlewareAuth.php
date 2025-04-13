<?php

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\RequestHandlerInterface;
use \Psr\Http\Message\ResponseInterface;

class MiddlewareAuth implements \Psr\Http\Server\MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // list all the public routes that don't need you to be logged in.
        $publicRoutes = [
            "login",
            "google-response-handler",
            "login-with-google",
            "logout",
        ];

        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $uri = $_SERVER['REQUEST_URI'];

        if (in_array($route->getName(), $publicRoutes) === false && AuthLib::isLoggedIn() === false)
        {
            $response = new \Slim\Psr7\Response(302);
            $response = $response->withHeader('Location', '/login');
        }
        else
        {
            $response = $handler->handle($request);
        }

        return $response;
    }
}