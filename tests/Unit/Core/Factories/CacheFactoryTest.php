<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\CacheFactory;
use Mockery as m;

final class CacheFactoryTest extends TestCase
{
    public function testFilesystem()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\FileSystem', $pool->getDriver());
    }

    public function testSqlite()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'sqlite'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Sqlite', $pool->getDriver());
    }

    public function testApc()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'apc'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Apc', $pool->getDriver());
    }

    public function testMemcache()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'memcache'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Memcache', $pool->getDriver());
    }

    public function testRedis()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'redis'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Redis', $pool->getDriver());
    }
}
