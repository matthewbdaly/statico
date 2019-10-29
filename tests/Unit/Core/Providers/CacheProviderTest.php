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

    public function testCreatePool(): void
    {
        $cache = $this->container->get('Stash\Pool');
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $cache);
        $this->assertInstanceOf('Stash\Pool', $cache);
    }

    public function testCreateService(): void
    {
        $cache = $this->container->get('Statico\Core\Contracts\Services\CacheContract');
        $this->assertInstanceOf('Statico\Core\Services\Cache\Psr6Cache', $cache);
        $this->assertInstanceOf('Statico\Core\Contracts\Services\CacheContract', $cache);
    }
}
