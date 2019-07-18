<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Sources\Decorators;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Sources\Decorators\Psr6CacheDecorator;
use Statico\Core\Utilities\Collection;
use Statico\Core\Objects\Document;

final class Psr6CacheDecoratorTest extends TestCase
{
    public function testAllHit()
    {
        $result = Collection::make([]);
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->once()->andReturn($item);
        $item->shouldReceive('isHit')->once()->andReturn(true);
        $item->shouldReceive('get')->once()->andReturn($result);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $decorator = new Psr6CacheDecorator($cache, $source);
        $decorator->all();
    }

    public function testAllMiss()
    {
        $result = Collection::make([]);
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->once()->andReturn($item);
        $cache->shouldReceive('save')->once()->with($item);
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->once()->with($result);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn($result);
        $decorator = new Psr6CacheDecorator($cache, $source);
        $decorator->all();
    }

    public function testFindHit()
    {
        $result = new Document;
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->once()->andReturn($cache);
        $cache->shouldReceive('isHit')->once()->andReturn(true);
        $cache->shouldReceive('get')->once()->andReturn($result);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $decorator = new Psr6CacheDecorator($cache, $source);
        $decorator->find('foo');
    }

    public function testFindMiss()
    {
        $result = new Document;
        $item = m::mock('Psr\Cache\CacheItemInterface');
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('getItem')->once()->andReturn($item);
        $cache->shouldReceive('save')->once()->with($item);
        $item->shouldReceive('isHit')->once()->andReturn(false);
        $item->shouldReceive('set')->once()->with($result);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->with('foo')->once()->andReturn($result);
        $decorator = new Psr6CacheDecorator($cache, $source);
        $decorator->find('foo');
    }
}
