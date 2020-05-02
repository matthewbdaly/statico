<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Plugins\DynamicSearch;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DynamicSearch\Plugin;

final class PluginTest extends TestCase
{
    public function testSetup()
    {
        $router = m::mock('League\Route\Router');
        $plugin = new Plugin($router);
        $router->shouldReceive('get')
            ->with('/search/index', 'Statico\Plugins\DynamicSearch\Http\Controllers\SearchController::index')
            ->once();
        $plugin->register();
    }
}
