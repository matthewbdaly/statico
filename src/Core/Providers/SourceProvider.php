<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Sources\Decorators\Psr6CacheDecorator;

final class SourceProvider extends AbstractServiceProvider
{
    protected $provides = ['Statico\Core\Contracts\Sources\Source'];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $config = $container->get('PublishingKit\Config\Config');
        $container->add('Statico\Core\Contracts\Sources\Source', function () use ($config, $container) {
            return $container->get($config->get('source'));
        });
    }
}
