<?php

declare(strict_types=1);

use Statico\Core\Kernel\HttpCache\HttpCache;
use PublishingKit\Cache\Factories\StashCacheFactory;
use Statico\Core\Kernel\Application;
use PublishingKit\Config\Config;

require_once __DIR__ . '/../bootstrap.php';

if (!defined('PUBLIC_DIR')) {
    define('PUBLIC_DIR', __DIR__);
}

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$config = new Config([
                      'driver' => 'filesystem',
                      'path'   => 'cache/proxy',
                     ]);
if (getenv('CACHE_PROXY') == true) {
    $cache = (new StashCacheFactory())->make($config->toArray());
    $app = new HttpCache(
        (new Application())->bootstrap(),
        $cache
    );
} else {
    $app = (new Application())->bootstrap();
}
$response = $app->handle($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
