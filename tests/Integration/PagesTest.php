<?php declare(strict_types = 1);

namespace Tests\Integration;

use Tests\IntegrationTestCase;

/**
 * @runTestsInSeparateProcesses
 */
class PagesTest extends IntegrationTestCase
{
    public function testHome(): void
    {
        $this->makeRequest('/')
            ->assertStatusCode(200);
    }

    public function testLogin(): void
    {
        $this->makeRequest('/about')
            ->assertStatusCode(200);
    }
}
