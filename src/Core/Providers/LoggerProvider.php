<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Factories\LoggerFactory;

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
            $config = $container->get('Laminas\Config\Config');
            $factory = new LoggerFactory();
            return $factory->make($config->get('loggers'));
        });
    }
}
