<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Statico\Core\Console\Runner;
use Statico\Core\Application;
use Mockery as m;
use ReflectionClass;

final class RunnerTest extends TestCase
{
    public function testExecute()
    {
        $console = m::mock('Symfony\Component\Console\Application');
        $console->shouldReceive('add')->times(5);
        $console->shouldReceive('run')->once();
        $container = m::mock('League\Container\Container');
        $container->shouldReceive('get')
            ->with('Symfony\Component\Console\Application')
            ->once()
            ->andReturn($console);
        $mockCommand = m::mock('Symfony\Component\Console\Command\Command');
        $container->shouldReceive('get')
            ->with('Statico\Core\Console\FlushCache')
            ->once()
            ->andReturn($mockCommand);
        $container->shouldReceive('get')
            ->with('Statico\Core\Console\Shell')
            ->once()
            ->andReturn($mockCommand);
        $container->shouldReceive('get')
            ->with('Statico\Core\Console\Server')
            ->once()
            ->andReturn($mockCommand);
        $container->shouldReceive('get')
            ->with('Statico\Core\Console\GenerateIndex')
            ->once()
            ->andReturn($mockCommand);
        $container->shouldReceive('get')
            ->with('Statico\Core\Console\GenerateSitemap')
            ->once()
            ->andReturn($mockCommand);
        $mockApp = m::mock(new Application());
        $mockApp->shouldReceive('getContainer')
            ->once()
            ->andReturn($container);
        $runner = new Runner();
        $reflect = new ReflectionClass($runner);
        $app = $reflect->getProperty('app');
        $app->setAccessible(true);
        $app->setValue($runner, $mockApp);
        $runner();
    }

    public function testCatchError()
    {
        $this->expectOutputRegex('/^Unable to run/');
        $mockApp = m::mock(new Application());
        $mockApp->shouldReceive('getContainer')
            ->once()
            ->andThrow('Exception');
        $runner = new Runner();
        $reflect = new ReflectionClass($runner);
        $app = $reflect->getProperty('app');
        $app->setAccessible(true);
        $app->setValue($runner, $mockApp);
        $runner();
    }
}
