<?php

declare(strict_types=1);

namespace Tests\Unit\Plugins\DynamicSitemap;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DynamicSitemap\Plugin;

final class PluginTest extends TestCase
{
    public function testSetup()
    {
        $router = m::mock('League\Route\Router');
        $plugin = new Plugin($router);
        $router->shouldReceive('get')
            ->with('/sitemap', 'Statico\Plugins\DynamicSitemap\Http\Controllers\SitemapController::index')
            ->once();
        $plugin->register();
    }
}
