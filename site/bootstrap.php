<?php



require_once(__DIR__ . "/vendor/autoload.php");

new \iRAP\Autoloader\Autoloader([
    __DIR__,
    __DIR__ . "/controllers",
    __DIR__ . "/models",
    __DIR__ . "/middleware",
    __DIR__ . "/libs",
    __DIR__ . "/views",
]);


$dotenv = new \Symfony\Component\Dotenv\Dotenv(__DIR__ . '/.env');
$dotenv->overload(__DIR__ . '/../.env');

require_once(__DIR__ . "/defines.php");
