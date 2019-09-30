<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Kernel\Application;
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
        error_reporting(E_ALL);
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

    public function testClockwork()
    {
        putenv('APP_ENV=development');
        if (defined('E_STRICT')) {
            error_reporting('E_ALL | E_STRICT');
        }
        $handler = m::mock('Statico\Core\Contracts\Exceptions\Handler');
        $clockwork = m::mock('Clockwork\Support\Vanilla\Clockwork')->makePartial();
        $clockwork->shouldReceive('requestProcessed')->once();
        $container = m::mock('League\Container\Container');
        $container->shouldReceive('delegate')->once();
        $container->shouldReceive('addServiceProvider');
        $container->shouldReceive('share');
        $container->shouldReceive('get')->with('Clockwork\Support\Vanilla\Clockwork')
            ->once()
            ->andReturn($clockwork);
        $router = m::mock('League\Route\Router');
        $router->shouldReceive('get')
            ->with('/__clockwork/{request:.+}', 'Statico\Core\Http\Controllers\ClockworkController::process')
            ->once()
            ->andReturn($router);
        $router->shouldReceive('get')->andReturn($router);
        $router->shouldReceive('middleware')->andReturn($router);
        $router->shouldReceive('post')->andReturn($router);
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $router->shouldReceive('dispatch')->andReturn($response);
        $container->shouldReceive('get')->with('League\Route\Router')
            ->once()
            ->andReturn($router);
        $container->shouldReceive('get')->with('Zend\Config\Config')
            ->once()
            ->andReturn(new Config([]));
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $app = new Application($container);
        $app->bootstrap();
        $this->assertEquals($response, $app->handle($request));
    }
}
