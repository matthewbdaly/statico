<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\GenerateIndex;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateIndexTest extends TestCase
{
    public function testExecute()
    {
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn([[
            'foo'
        ]]);
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('put')
            ->with('assets://index.json', json_encode([['foo']], JSON_UNESCAPED_SLASHES))
            ->once();
        $cmd = new GenerateIndex($source, $manager);
        $tester = new CommandTester($cmd);
        $tester->execute([]);
    }
}
