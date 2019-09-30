<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Application;

final class ConsoleProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Symfony\Component\Console\Application',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('Symfony\Component\Console\Application', function () {
                return new Application();
            });
    }
}
