<?php declare(strict_types = 1);

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
        $response = $cache->handle($request);
    }
}
