<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\FlushCache;
use Symfony\Component\Console\Tester\CommandTester;

final class FlushCacheTest extends TestCase
{
    public function testExecute()
    {
        $cache = m::mock('Psr\Cache\CacheItemPoolInterface');
        $cache->shouldReceive('purge')->once();
        $cmd = new FlushCache($cache);
        $tester = new CommandTester($cmd);
        $tester->execute([]);
    }
}
