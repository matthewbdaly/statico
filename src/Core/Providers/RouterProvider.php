<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

final class RouterProvider extends AbstractServiceProvider
{
    protected $provides = [
        'League\Route\Router',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('League\Route\Router', function () {
                $strategy = (new ApplicationStrategy())->setContainer($this->getContainer());
                $router = new Router();
                $router->setStrategy($strategy);
                return $router;
            });
    }
}
