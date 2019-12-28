<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class CacheProviderTest extends TestCase
{
    public function testCreateCache(): void
    {
        $cache = $this->container->get('Psr\Cache\CacheItemPoolInterface');
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $cache);
        $this->assertInstanceOf('Stash\Pool', $cache);
    }

    public function testCreateFactory(): void
    {
        $factory = $this->container->get('PublishingKit\Cache\Contracts\Factories\CacheFactory');
        $this->assertInstanceOf('PublishingKit\Cache\Contracts\Factories\CacheFactory', $factory);
        $this->assertInstanceOf('PublishingKit\Cache\Factories\StashCacheFactory', $factory);
    }

    public function testCreatePool(): void
    {
        $cache = $this->container->get('Stash\Pool');
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $cache);
        $this->assertInstanceOf('Stash\Pool', $cache);
    }

    public function testCreateService(): void
    {
        $cache = $this->container->get('PublishingKit\Cache\Contracts\Services\CacheContract');
        $this->assertInstanceOf('PublishingKit\Cache\Services\Cache\Psr6Cache', $cache);
        $this->assertInstanceOf('PublishingKit\Cache\Contracts\Services\CacheContract', $cache);
    }
}
