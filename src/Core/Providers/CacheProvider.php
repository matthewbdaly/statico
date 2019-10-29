<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Factories\CacheFactory;
use Statico\Core\Services\Cache\Psr6Cache;

final class CacheProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Stash\Pool',
        'Psr\Cache\CacheItemPoolInterface',
        'Statico\Core\Contracts\Services\CacheContract'
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Stash\Pool', function () use ($container) {
            $factory = $container->get('Statico\Core\Factories\CacheFactory');
            $config = $container->get('Zend\Config\Config');
            return $factory->make($config->cache);
        });
        $container->add('Psr\Cache\CacheItemPoolInterface', function () {
            return $this->getContainer()->get('Stash\Pool');
        });
        $container->add('Statico\Core\Contracts\Services\CacheContract', function () use ($container) {
            return new Psr6Cache($this->container->get('Psr\Cache\CacheItemPoolInterface'));
        });
    }
}
