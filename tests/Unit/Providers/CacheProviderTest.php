<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class CacheProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $container = $this->container->get('Psr\Cache\CacheItemPoolInterface');
        $this->assertInstanceOf('Psr\Cache\CacheItemPoolInterface', $container);
        $this->assertInstanceOf('Stash\Pool', $container);
    }
}
