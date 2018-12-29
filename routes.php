<?php declare(strict_types = 1);

$router->get('/{name:word}', 'Statico\Core\Http\Controllers\MainController::index');
