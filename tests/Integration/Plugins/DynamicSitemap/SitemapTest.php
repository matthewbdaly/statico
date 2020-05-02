<?php

declare(strict_types=1);

namespace Statico\Tests\Integration\Plugins\DynamicSitemap;

use Statico\Tests\IntegrationTestCase;

final class SitemapTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->makeRequest('/sitemap')
            ->assertStatusCode(200);
    }
}
