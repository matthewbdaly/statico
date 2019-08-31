<?php declare(strict_types=1);

use Statico\Core\Kernel\HttpCache\HttpCache;
use Statico\Core\Kernel\HttpCache\Store\FileStore;
use Statico\Core\Kernel\HttpCache\Store\PredisStore;
use Predis\Client;
use Statico\Core\Kernel\Application;

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

/* $app = new HttpCache( */
/*     (new Application())->bootstrap(), */
/*     //new FileStore(__DIR__ . '/../cache/pages') */
/*     new PredisStore(new Client()) */
/* ); */
$app = (new Application())->bootstrap();
$response = $app->handle($request);

// send the response to the browser
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
