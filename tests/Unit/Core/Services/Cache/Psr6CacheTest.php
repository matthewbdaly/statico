<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services\Cache;

use Tests\TestCase;
use Statico\Core\Services\Cache\Psr6Cache;
use Mockery as m;

final class Psr6CacheTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $container = m::mock('Psr\Container\ContainerInterface');
        $container->shouldReceive('get')->with('Psr\Cache\CacheItemPoolInterface')->andReturn($this->cache);
        $this->wrapper = new Psr6Cache($this->cache);
    }

    public function tearDown(): void
    {
        unset($this->cache);
        unset($this->wrapper);
        parent::tearDown();
    }

    public function testGetSuccess()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn('bar');
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('bar', $this->wrapper->get('foo'));
    }

    public function testGetFail()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertNull($this->wrapper->get('foo'));
    }

    public function testGetFailDefault()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('baz', $this->wrapper->get('foo', 'baz'));
    }

    public function testPut()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('set')->with('bar')->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->wrapper->put('foo', 'bar');
    }

    public function testPutExpiryCount()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('set')->with('bar')->once();
        $item->shouldReceive('expiresAfter')->with(300)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->wrapper->put('foo', 'bar', 300);
    }

    public function testPutExpiryDateTime()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('set')->with('bar')->once();
        $dt = new \DateTime();
        $item->shouldReceive('expiresAt')->with($dt)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->wrapper->put('foo', 'bar', $dt);
    }

    public function testPutInvalidExpiry()
    {
        $this->expectException('TypeError');
        $this->wrapper->put('foo', 'bar', new \stdClass());
    }

    public function testForever()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('set')->with('bar')->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->wrapper->forever('foo', 'bar');
    }

    public function testForget()
    {
        $this->cache->shouldReceive('deleteItem')->with('foo')->once();
        $this->wrapper->forget('foo');
    }

    public function testHasTrue()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertTrue($this->wrapper->has('foo'));
    }

    public function testHasFalse()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertFalse($this->wrapper->has('foo'));
    }

    public function testRememberForeverTrue()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn('bar');
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('bar', $this->wrapper->rememberForever('foo', function () {
            return 'baz';
        }));
    }

    public function testRememberForeverTrueWithInvokable()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn('bar');
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('bar', $this->wrapper->rememberForever('foo', new class {
            public function __invoke()
            {
                return 'baz';
            }
        }));
    }

    public function testRememberForeverFalse()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->rememberForever('foo', function () {
            return 'baz';
        }));
    }

    public function testRememberForeverFalseWithInvokable()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->rememberForever('foo', new class {
            public function __invoke()
            {
                return 'baz';
            }
        }));
    }

    public function testRememberTrue()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn('bar');
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('bar', $this->wrapper->remember('foo', 300, function () {
            return 'baz';
        }));
    }

    public function testRememberInvalidExpiry()
    {
        $this->expectException('TypeError');
        $this->wrapper->remember('foo', new \stdClass(), function () {
            return 'baz';
        });
    }

    public function testRememberTrueWithInvokable()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn('bar');
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->assertEquals('bar', $this->wrapper->remember('foo', 300, new class {
            public function __invoke()
            {
                return 'baz';
            }
        }));
    }

    public function testRememberFalse()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $item->shouldReceive('expiresAfter')->with(300)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->remember('foo', 300, function () {
            return 'baz';
        }));
    }

    public function testRememberFalseWithInvokable()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $item->shouldReceive('expiresAfter')->with(300)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->remember('foo', 300, new class {
            public function __invoke()
            {
                return 'baz';
            }
        }));
    }

    public function testRememberFalseWithExpiryDate()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $dt = new \DateTime();
        $item->shouldReceive('expiresAt')->with($dt)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->remember('foo', $dt, function () {
            return 'baz';
        }));
    }

    public function testRememberFalseWithInvokableAndExpiryDate()
    {
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->with('baz')->once();
        $dt = new \DateTime();
        $item->shouldReceive('expiresAt')->with($dt)->once();
        $this->cache->shouldReceive('getItem')->with('foo')->once()->andReturn($item);
        $this->cache->shouldReceive('save')->with($item)->once();
        $this->assertEquals('baz', $this->wrapper->remember('foo', $dt, new class {
            public function __invoke()
            {
                return 'baz';
            }
        }));
    }

    public function testFlush()
    {
        $this->cache->shouldReceive('clear')->once();
        $this->wrapper->flush();
    }
}
