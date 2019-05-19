<?php declare(strict_types = 1);

$router->get('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::index')
    ->middleware(new \Statico\Core\Http\Middleware\ETag);
$router->post('/[{name:[a-zA-Z0-9\-\/]+}]', 'Statico\Core\Http\Controllers\MainController::submit');
