<?php declare(strict_types = 1);

namespace Statico\Plugins\DynamicSearch;

use League\Route\Router;

final class Plugin
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function register()
    {
        $this->registerRoute();
    }

    private function registerRoute()
    {
        $this->router->get('/index.json', 'Statico\Plugins\DynamicSearch\Http\Controllers\SearchController::index');
    }
}
