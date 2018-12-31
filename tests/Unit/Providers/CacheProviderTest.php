<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class CacheProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $cache = $this->container->get('Psr\Cache\CacheItemPoolInterface');
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $cache);
        $this->assertInstanceOf('Stash\Pool', $cache);
    }
}
