<?php declare(strict_types = 1);

namespace Tests\Integration;

use Tests\IntegrationTestCase;

/**
 * @runTestsInSeparateProcesses
 */
final class PagesTest extends IntegrationTestCase
{
    public function testHome(): void
    {
        $this->makeRequest('/')
            ->assertStatusCode(200);
    }

    public function testAbout(): void
    {
        $this->makeRequest('/about')
            ->assertStatusCode(200);
    }

    public function testPostToForm(): void
    {
        $params = [
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'message' => 'Just testing'
        ];
        $this->makeRequest(
            '/contact',
            'POST',
            [],
            [],
            'php://input',
            [],
            [],
            [],
            $params
        )->assertStatusCode(200);
    }

    public function test404(): void
    {
        $this->makeRequest('/foo')
            ->assertStatusCode(404);
    }

    public function testPost404(): void
    {
        $this->makeRequest('/foo', 'POST')
            ->assertStatusCode(404);
    }
}
