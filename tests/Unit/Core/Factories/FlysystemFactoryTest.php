<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FlysystemFactory;
use Mockery as m;

class FlysystemFactoryTest extends TestCase
{
    public function testLocal()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'path' => 'content/'
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\Adapter\Local', $cache->getAdapter());
    }
}
