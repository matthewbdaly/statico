<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console\Commands;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\Commands\FlushCache;
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
        $this->assertEquals('cache:flush', $cmd->getName());
        $this->assertEquals('Flushes the cache', $cmd->getDescription());
        $this->assertEquals('This command will flush the cache', $cmd->getHelp());
    }
}
