<?php declare(strict_types = 1);

require_once __DIR__.'/../vendor/autoload.php';

if (!defined('BASE_DIR')) {
    define('BASE_DIR', __DIR__.'/../');
}

error_reporting(E_ALL);

$dotenv = new Dotenv\Dotenv(BASE_DIR);
$dotenv->load();
if (getenv('APP_ENV') == 'development') {
    ini_set('display_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
 
$app = new Statico\Core\Kernel;
$response = $app->bootstrap()
    ->handle($request);

// send the response to the browser
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
