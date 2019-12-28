<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Console\Commands;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\Commands\GenerateIndex;
use PublishingKit\Utilities\Collections\Collection;
use Symfony\Component\Console\Tester\CommandTester;

final class GenerateIndexTest extends TestCase
{
    public function testExecute()
    {
        $response = Collection::make([['foo']]);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn($response);
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('put')
            ->with('assets://index.json', json_encode($response->toArray(), JSON_UNESCAPED_SLASHES))
            ->once();
        $cmd = new GenerateIndex($source, $manager);
        $tester = new CommandTester($cmd);
        $tester->execute([]);
        $this->assertEquals('index:generate', $cmd->getName());
        $this->assertEquals('Generates the search index', $cmd->getDescription());
        $this->assertEquals('This command will generate the search index file', $cmd->getHelp());
    }
}
