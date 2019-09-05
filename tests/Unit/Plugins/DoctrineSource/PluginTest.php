<?php declare(strict_types = 1);

namespace Tests\Unit\Plugins\DoctrineSource;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DoctrineSource\Plugin;

final class PluginTest extends TestCase
{
    public function testSetup()
    {
        $container = m::mock('Psr\Container\ContainerInterface');
        $console = m::mock('Symfony\Component\Console\Application');
        $console->shouldReceive('setHelperSet');
        $console->shouldReceive('addCommands');
        $plugin = new Plugin($container, $console);
        $container->shouldReceive('addServiceProvider')
            ->with('Statico\Plugins\DoctrineSource\Providers\DoctrineProvider');
        $conn = m::mock('Doctrine\DBAL\Connection');
        $em = m::mock('Doctrine\ORM\EntityManager');
        $em->shouldReceive('getConnection')->andReturn($conn);
        $container->shouldReceive('get')->with('Doctrine\ORM\EntityManager')
            ->andReturn($em);
        $plugin->register();
    }
}
