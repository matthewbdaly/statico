<?php declare(strict_types = 1);

namespace Statico\Plugins\Admin;

use Statico\Core\Contracts\Extension\Plugin;
use League\Route\Router;

final class Main implements Plugin
{
    protected $route;

    public function __construct(Router $route)
    {
        $this->route = $route;
    }

    public function register()
    {
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        $this->router->get('/admin', 'Statico\Plugins\Admin\Http\Controllers\AdminController::index');
    }
}
