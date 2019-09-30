<?php

declare(strict_types=1);

use Statico\Core\Kernel\HttpCache\HttpCache;
use Statico\Core\Kernel\HttpCache\Store\Psr6Store;
use Statico\Core\Factories\CacheFactory;
use Statico\Core\Kernel\Application;
use Zend\Config\Config;

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

$config = new Config([
    'driver' => 'filesystem',
    'path' => 'cache/proxy'
]);
$cache = (new CacheFactory())->make($config);
$app = new HttpCache(
    (new Application())->bootstrap(),
    new Psr6Store($cache)
);
$response = $app->handle($request);

// send the response to the browser
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
