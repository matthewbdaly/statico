<?php declare(strict_types = 1);

$router->get('/', 'Statico\Core\Http\Controllers\MainController::index');
$router->get('/{name:[a-zA-Z0-9\-\/]+}', 'Statico\Core\Http\Controllers\MainController::index');
