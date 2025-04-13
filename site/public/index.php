<?php

require_once(__DIR__ . '/../bootstrap.php');

// Manually include any objects here (before session start) that we may need for storing in the session.
require_once(__DIR__ . "/../models/GoogleAccessTokenObject.php");

// Start session here instead of in bootstrap, as this is entrypoint for web requests, and bootstrap should also
// be used from CLI scripts/tools.
session_start();

$app = Slim\Factory\AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addMiddleware(new MiddlewareAuth());
$app->addRoutingMiddleware();
$app->addMiddleware(new MiddlewareTrailingSlash()); // this must be last (which means it executes first).
$app->addErrorMiddleware($displayErrorDetails=true, $logErrors=true, $logErrorDetails=true);

HomeController::registerRoutes($app);

$app->run();