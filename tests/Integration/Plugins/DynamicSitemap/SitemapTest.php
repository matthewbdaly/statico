<?php declare(strict_types = 1);

namespace Tests\Integration\Plugins\DynamicSitemap;

use Tests\IntegrationTestCase;

final class SitemapTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->makeRequest('/sitemap')
            ->assertStatusCode(200);
    }
}
