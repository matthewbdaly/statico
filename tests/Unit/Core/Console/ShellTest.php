<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\Shell;
use Symfony\Component\Console\Tester\CommandTester;

class ShellTest extends TestCase
{
    public function testExecute()
    {
        $container = m::mock('Psr\Container\ContainerInterface');
        $shell = m::mock('Psy\Shell');
        $shell->shouldReceive('setScopeVariables')->with(['container' => $container])->once();
        $shell->shouldReceive('run')
            ->once()
            ->andReturn(true);
        $cmd = new Shell($container, $shell);
        $tester = new CommandTester($cmd);
        $tester->execute([]);
    }
}
