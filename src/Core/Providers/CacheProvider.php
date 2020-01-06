<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PublishingKit\Cache\Services\Cache\Psr6Cache;
use PublishingKit\Cache\Factories\StashCacheFactory;

final class CacheProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Stash\Pool',
        'Psr\Cache\CacheItemPoolInterface',
        'PublishingKit\Cache\Contracts\Services\CacheContract',
        'PublishingKit\Cache\Contracts\Factories\CacheFactory'
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('PublishingKit\Cache\Contracts\Factories\CacheFactory', function () use ($container) {
            return new StashCacheFactory();
        });
        $container->add('Stash\Pool', function () use ($container) {
            $factory = $container->get('PublishingKit\Cache\Contracts\Factories\CacheFactory');
            $config = $container->get('Laminas\Config\Config');
            return $factory->make($config->cache->toArray());
        });
        $container->add('Psr\Cache\CacheItemPoolInterface', function () {
            return $this->getContainer()->get('Stash\Pool');
        });
        $container->add('PublishingKit\Cache\Contracts\Services\CacheContract', function () use ($container) {
            return new Psr6Cache($this->container->get('Psr\Cache\CacheItemPoolInterface'));
        });
    }
}
