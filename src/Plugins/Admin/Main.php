<?php declare(strict_types = 1);

namespace Statico\Plugins\Admin;

use Statico\Core\Contracts\Extension\Plugin;
use League\Route\Router;
use Twig\Loader\FilesystemLoader;

final class Main implements Plugin
{
    /**
     * @var Router
     */
    protected $route;

    /**
     * @var FilesystemLoader
     */
    protected $twig;

    public function __construct(Router $route, FilesystemLoader $twig)
    {
        $this->route = $route;
        $this->twig = $twig;
    }

    public function register(): void
    {
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        $this->route->get('/admin', 'Statico\Plugins\Admin\Http\Controllers\AdminController::index');
    }

    public function getViews(): array
    {
        return [
            dirname(__FILE__) . '/views',
        ];
    }
}
