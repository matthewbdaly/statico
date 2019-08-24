<?php declare(strict_types=1);

use Statico\Core\Application;

require_once __DIR__ . '/../bootstrap.php';

if (!defined('PUBLIC_DIR')) {
    define('PUBLIC_DIR', __DIR__);
}

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$app = new Statico\Core\Application();
$response = $app->bootstrap()
    ->handle($request);

// send the response to the browser
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
