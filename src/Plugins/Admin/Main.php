<?php declare(strict_types = 1);

namespace Statico\Plugins\Admin;

use Statico\Core\Contracts\Extension\Plugin;
use League\Route\Router;
use Twig_Loader_Filesystem;

final class Main implements Plugin
{
    /**
     * @var Router
     */
    protected $route;

    /**
     * @var Twig_Loader_Filesystem
     */
    protected $twig;

    public function __construct(Router $route, Twig_Loader_Filesystem $twig)
    {
        $this->route = $route;
        $this->twig = $twig;
    }

    public function register()
    {
        $this->registerRoutes();
        $this->registerViews();
    }

    private function registerRoutes()
    {
        $this->route->get('/admin', 'Statico\Plugins\Admin\Http\Controllers\AdminController::index');
    }

    private function registerViews()
    {
        $this->twig->addPath(dirname(__FILE__) . '/views', 'admin');
    }
}
