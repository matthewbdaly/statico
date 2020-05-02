<?php

declare(strict_types=1);

namespace Statico\Tests\Integration\Plugins\DynamicSearch;

use Statico\Tests\IntegrationTestCase;

final class IndexTest extends IntegrationTestCase
{
    public function testIndex(): void
    {
        $this->makeRequest('/search/index')
            ->assertStatusCode(200);
    }
}
