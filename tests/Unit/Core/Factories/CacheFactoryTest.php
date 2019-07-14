<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\CacheFactory;
use Stash\Exception\RuntimeException;
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

    public function testBlackhole()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'test'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\BlackHole', $pool->getDriver());
    }

    public function testEphemeral()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'ephemeral'
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Ephemeral', $pool->getDriver());
    }

    public function testComposite()
    {
        $factory = new CacheFactory;
        $pool = $factory->make([
            'driver' => 'composite',
            'subdrivers' => [[
                'driver' => 'ephemeral',
            ], [
                'driver' => 'filesystem',
            ]]
        ]);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Composite', $pool->getDriver());
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
        try {
            $pool = $factory->make([
                'driver' => 'apc'
            ]);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Apc', $pool->getDriver());
    }

    public function testMemcache()
    {
        $factory = new CacheFactory;
        try {
            $pool = $factory->make([
                'driver' => 'memcache',
                'servers' => [[
                    '127.0.0.1',
                    '11211'
                ]]
            ]);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Memcache', $pool->getDriver());
    }

    public function testRedis()
    {
        $factory = new CacheFactory;
        try {
            $pool = $factory->make([
                'driver' => 'redis',
                'servers' => [[
                    '127.0.0.1',
                    '6379'
                ]]
            ]);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Redis', $pool->getDriver());
    }
}
