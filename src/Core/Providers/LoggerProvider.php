<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Factories\MonologFactory;

final class LoggerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Psr\Log\LoggerInterface',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Psr\Log\LoggerInterface', function () use ($container) {
            $config = $container->get('PublishingKit\Config\Config');
            $factory = new MonologFactory();
            return $factory->make($config->get('loggers'));
        });
    }
}
