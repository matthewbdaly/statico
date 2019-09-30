<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\HttpCache;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Kernel\HttpCache\HttpCache;

final class HttpCacheTest extends TestCase
{
    public function testNotGet()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')
            ->once()
            ->andReturn('POST');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $kernel = m::mock('Statico\Core\Contracts\Kernel\KernelInterface');
        $kernel->shouldReceive('handle')
            ->with($request)
            ->once()
            ->andReturn($response);
        $store = m::mock('Statico\Core\Contracts\Kernel\HttpCache\StoreInterface');
        $cache = new HttpCache($kernel, $store);
        $cache->handle($request);
    }

    public function testGetCached()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')
            ->once()
            ->andReturn('GET');
        $kernel = m::mock('Statico\Core\Contracts\Kernel\KernelInterface');
        $store = m::mock('Statico\Core\Contracts\Kernel\HttpCache\StoreInterface');
        $store->shouldReceive('get')
            ->once()
            ->andReturn('foo');
        $cache = new HttpCache($kernel, $store);
        $response = $cache->handle($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("foo", $response->getBody()->getContents());
    }

    public function testGetNon200()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')
            ->once()
            ->andReturn('GET');
        $mockResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $mockResponse->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(201);
        $mockResponse->shouldReceive('getHeader')
            ->with('Cache-Control')
            ->once()
            ->andReturn([]);
        $kernel = m::mock('Statico\Core\Contracts\Kernel\KernelInterface');
        $kernel->shouldReceive('handle')
            ->with($request)
            ->once()
            ->andReturn($mockResponse);
        $store = m::mock('Statico\Core\Contracts\Kernel\HttpCache\StoreInterface');
        $store->shouldReceive('get')
            ->once()
            ->andReturn(null);
        $cache = new HttpCache($kernel, $store);
        $response = $cache->handle($request);
        $this->assertSame($response, $mockResponse);
    }

    public function testGet200()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')
            ->once()
            ->andReturn('GET');
        $mockResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $mockResponse->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(200);
        $mockResponse->shouldReceive('getHeader')
            ->with('Cache-Control')
            ->once()
            ->andReturn([]);
        $kernel = m::mock('Statico\Core\Contracts\Kernel\KernelInterface');
        $kernel->shouldReceive('handle')
            ->with($request)
            ->once()
            ->andReturn($mockResponse);
        $store = m::mock('Statico\Core\Contracts\Kernel\HttpCache\StoreInterface');
        $store->shouldReceive('get')
            ->with($request)
            ->once()
            ->andReturn(null);
        $store->shouldReceive('put')
            ->with($request, $mockResponse)
            ->once();
        $cache = new HttpCache($kernel, $store);
        $response = $cache->handle($request);
        $this->assertSame($response, $mockResponse);
    }
}
