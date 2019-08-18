<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Utilities;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Application;
use Zend\Config\Config;

final class ApplicationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        putenv('APP_ENV=production');
    }

    public function tearDown(): void
    {
        putenv('APP_ENV=testing');
        parent::tearDown();
    }

    public function testErrorHandler()
    {
        $handler = m::mock('Statico\Core\Contracts\Exceptions\Handler');
        $router = m::mock('League\Route\Router');
        $router->shouldReceive('get')
            ->andReturn($router);
        $router->shouldReceive('middleware')
            ->andReturn($router);
        $router->shouldReceive('post')
            ->andReturn($router);
        $container = m::mock('League\Container\Container');
        $container->shouldReceive('delegate')->once();
        $container->shouldReceive('addServiceProvider');
        $container->shouldReceive('share')->times(2);
        $container->shouldReceive('get')->with('League\Route\Router')
            ->once()
            ->andReturn($router);
        $container->shouldReceive('get')->with('Statico\Core\Contracts\Exceptions\Handler')
            ->once()
            ->andReturn($handler);
        $container->shouldReceive('get')->with('Zend\Config\Config')
            ->once()
            ->andReturn(new Config([]));
        $app = new Application($container);
        $app->bootstrap();
    }

    public function testPluginNotFound()
    {
        $this->expectException('Statico\Core\Exceptions\Plugins\PluginNotFound');
        $handler = m::mock('Statico\Core\Contracts\Exceptions\Handler');
        $container = m::mock('League\Container\Container');
        $container->shouldReceive('delegate')->once();
        $container->shouldReceive('addServiceProvider');
        $container->shouldReceive('share')->times(2);
        $container->shouldReceive('get')->with('My\Nonexistent\Plugin')
            ->once()
            ->andReturn(null);
        $container->shouldReceive('get')->with('Statico\Core\Contracts\Exceptions\Handler')
            ->once()
            ->andReturn($handler);
        $config = new Config([
            'plugins' => [
                'My\Nonexistent\Plugin'
            ]
        ]);
        $container->shouldReceive('get')->with('Zend\Config\Config')
            ->once()
            ->andReturn($config);
        $app = new Application($container);
        $app->bootstrap();
    }

    public function testPluginNotValid()
    {
        $this->expectException('Statico\Core\Exceptions\Plugins\PluginNotValid');
        $handler = m::mock('Statico\Core\Contracts\Exceptions\Handler');
        $container = m::mock('League\Container\Container');
        $container->shouldReceive('delegate')->once();
        $container->shouldReceive('addServiceProvider');
        $container->shouldReceive('share')->times(2);
        $container->shouldReceive('get')->with('stdClass')
            ->once()
            ->andReturn(new \stdClass());
        $container->shouldReceive('get')->with('Statico\Core\Contracts\Exceptions\Handler')
            ->once()
            ->andReturn($handler);
        $config = new Config([
            'plugins' => [
                'stdClass'
            ]
        ]);
        $container->shouldReceive('get')->with('Zend\Config\Config')
            ->once()
            ->andReturn($config);
        $app = new Application($container);
        $app->bootstrap();
    }
}
