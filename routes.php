<?php declare(strict_types = 1);

$router->get('/', 'Statico\Core\Http\Controllers\MainController::index');
$router->get('/{name:word}', 'Statico\Core\Http\Controllers\MainController::index');
