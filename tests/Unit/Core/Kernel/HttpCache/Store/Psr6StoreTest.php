<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Kernel\HttpCache\Store;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Kernel\HttpCache\Store\Psr6Store;

final class Psr6StoreTest extends TestCase
{
    public function testGetEmpty()
    {
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->andReturn($cache);
        $cache->shouldReceive('isHit')->andReturn(false);
        $store = new Psr6Store($cache);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($request);
        $request->shouldReceive('getPath')->andReturn('/foo');
        $request->shouldReceive('getQuery')->andReturn('');
        $this->assertNull($store->get($request));
    }

    public function testGetNotEmpty()
    {
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->andReturn($cache);
        $cache->shouldReceive('isHit')->andReturn(true);
        $cache->shouldReceive('get')->andReturn('foo');
        $store = new Psr6Store($cache);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($request);
        $request->shouldReceive('getPath')->andReturn('/foo');
        $request->shouldReceive('getQuery')->andReturn('');
        $response = $store->get($request);
        $this->assertEquals("foo", $response);
    }

    public function testPut()
    {
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cacheItem = m::mock('Psr\Cache\CacheItemInterface');
        $cache->shouldReceive('getItem')->with('cached-foo.html')->andReturn($cacheItem);
        $cacheItem->shouldReceive('set')->with('foo')->once();
        $cache->shouldReceive('save')->with($cacheItem);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($request);
        $request->shouldReceive('getPath')->andReturn('/foo');
        $request->shouldReceive('getQuery')->andReturn('');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($response);
        $response->shouldReceive('__toString')->once()->andReturn('foo');
        $store = new Psr6Store($cache);
        $store->put($request, $response);
    }
}
