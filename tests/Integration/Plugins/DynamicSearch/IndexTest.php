<?php declare(strict_types = 1);

namespace Tests\Integration\Plugins\DynamicSearch;

use Tests\IntegrationTestCase;

final class IndexTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->makeRequest('/search/index')
            ->assertStatusCode(200);
    }
}
