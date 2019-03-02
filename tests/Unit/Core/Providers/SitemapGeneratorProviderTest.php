<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

class SitemapGeneratorProviderTest extends TestCase
{
    public function testCreateSouce(): void
    {
        $generator = $this->container->get('Statico\Core\Contracts\Generators\Sitemap');
        $this->assertInstanceOf('Statico\Core\Contracts\Generators\Sitemap', $generator);
        $this->assertInstanceOf('Statico\Core\Generators\XmlStringSitemap', $generator);
    }
}
