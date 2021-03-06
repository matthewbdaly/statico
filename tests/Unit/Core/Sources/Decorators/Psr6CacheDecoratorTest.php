<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Sources\Decorators;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Core\Sources\Decorators\Psr6CacheDecorator;
use PublishingKit\Utilities\Collections\Collection;
use Statico\Core\Objects\MarkdownDocument;

final class Psr6CacheDecoratorTest extends TestCase
{
    public function testAll()
    {
        $result = Collection::make([]);
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn($result);
        $decorator = new Psr6CacheDecorator($cache, $source);
        $decorator->all();
    }

    public function testFindHit()
    {
        $result = new MarkdownDocument();
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
        $result = new MarkdownDocument();
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
