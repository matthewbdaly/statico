<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\CacheFactory;
use Stash\Exception\RuntimeException;
use Mockery as m;

final class CacheFactoryTest extends TestCase
{
    public function testDefault()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\FileSystem', $pool->getDriver());
    }

    public function testFilesystem()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([
            'driver' => 'filesystem',
            'filePermissions' => 0660,
            'dirPermissions' => 0770,
            'dirSplit' => 2,
        ]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\FileSystem', $pool->getDriver());
    }

    public function testBlackhole()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([
            'driver' => 'test'
        ]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\BlackHole', $pool->getDriver());
    }

    public function testEphemeral()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([
            'driver' => 'ephemeral'
        ]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Ephemeral', $pool->getDriver());
    }

    public function testComposite()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([
            'driver' => 'composite',
            'subdrivers' => [[
                'driver' => 'ephemeral',
            ], [
                'driver' => 'filesystem',
            ]]
        ]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Composite', $pool->getDriver());
    }

    public function testSqlite()
    {
        $factory = new CacheFactory;
        $config = m::mock('Zend\Config\Config');
        $config->shouldReceive('toArray')->once()->andReturn([
            'driver' => 'sqlite'
        ]);
        $pool = $factory->make($config);
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Sqlite', $pool->getDriver());
    }

    public function testApc()
    {
        $factory = new CacheFactory;
        try {
            $config = m::mock('Zend\Config\Config');
            $config->shouldReceive('toArray')->once()->andReturn([
                'driver' => 'apc'
            ]);
            $pool = $factory->make($config);
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
            $config = m::mock('Zend\Config\Config');
            $config->shouldReceive('toArray')->once()->andReturn([
                'driver' => 'memcache',
                'servers' => [[
                    '127.0.0.1',
                    '11211'
                ]]
            ]);
            $pool = $factory->make($config);
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
            $config = m::mock('Zend\Config\Config');
            $config->shouldReceive('toArray')->once()->andReturn([
                'driver' => 'redis',
                'servers' => [[
                    '127.0.0.1',
                    '6379'
                ]]
            ]);
            $pool = $factory->make($config);
        } catch (RuntimeException $e) {
            $this->markTestSkipped('Dependency not installed');
        }
        $this->assertInstanceOf('Stash\Pool', $pool);
        $this->assertInstanceOf('Stash\Driver\Redis', $pool->getDriver());
    }
}
