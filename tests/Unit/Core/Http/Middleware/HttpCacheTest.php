<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Http\Middleware;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Core\Http\Middleware\HttpCache;

final class HttpCacheTest extends TestCase
{
    public function testNotGet()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')->andReturn('POST');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $handler = m::mock('Psr\Http\Server\RequestHandlerInterface');
        $handler->shouldReceive('handle')->with($request)->andReturn($response);
        $middleware = new HttpCache();
        $received = $middleware->process($request, $handler);
        $this->assertEquals($received, $response);
    }

    public function testGet()
    {
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $response->shouldReceive('getBody->getContents')->andReturn('foo');
        $response->shouldReceive('withAddedHeader')->andReturn($response);
        $handler = m::mock('Psr\Http\Server\RequestHandlerInterface');
        $handler->shouldReceive('handle')->with($request)->andReturn($response);
        $middleware = new HttpCache();
        $received = $middleware->process($request, $handler);
    }

    public function testInactiveInDevelopment()
    {
        putenv('APP_ENV=development');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getMethod')->andReturn('POST');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $handler = m::mock('Psr\Http\Server\RequestHandlerInterface');
        $handler->shouldReceive('handle')->with($request)->andReturn($response);
        $middleware = new HttpCache();
        $received = $middleware->process($request, $handler);
        $this->assertEquals($received, $response);
        putenv('APP_ENV=testing');
    }
}
