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
        $cache->shouldReceive('isHit')->andReturn(null);
        $store = new Psr6Store($cache);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getUri')->andReturn($request);
        $request->shouldReceive('getPath')->andReturn('/foo');
        $request->shouldReceive('getQuery')->andReturn('');
        $this->assertNull($store->get($request));
    }
}
