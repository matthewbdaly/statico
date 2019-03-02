<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Generators;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Objects\Document;
use Statico\Core\Generators\XmlStringSitemap;

class SitemapTest extends TestCase
{
    public function testExecute()
    {
        $expectedResponse = <<<EOF
<?xml version="1.0"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://mysite.com/foo/</loc>
  </url>
</urlset>
EOF;
        $doc = new Document;
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo.md');

        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn([
            $doc
        ]);
        $generator = new XmlStringSitemap($source);
        $response = $generator();
        $this->assertEquals($expectedResponse, $response);
    }
}
