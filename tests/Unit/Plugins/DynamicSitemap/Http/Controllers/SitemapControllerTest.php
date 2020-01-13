<?php

declare(strict_types=1);

namespace Tests\Unit\Plugins\DynamicSitemap\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DynamicSitemap\Http\Controllers\SitemapController;
use PublishingKit\Config\Config;

final class SitemapControllerTest extends TestCase
{
    public function testSitemap()
    {
        $response = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://mysite.com/foo/</loc>
  </url>
</urlset>
EOF;
        $generator = m::mock('Statico\Core\Contracts\Generators\Sitemap');
        $generator->shouldReceive('__invoke')->once()->andReturn($response);
        $controller = new SitemapController($generator);
        $result = $controller->index();
        $this->assertInstanceOf('Laminas\Diactoros\Response\XmlResponse', $result);
        $this->assertEquals($response, $result->getBody()->getContents());
    }
}
