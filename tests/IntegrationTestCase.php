<?php

declare(strict_types=1);

namespace Statico\Tests;

use Laminas\Diactoros\ServerRequest;

abstract class IntegrationTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        chdir('public');
    }

    public function makeRequest(string $uri, string $method = 'GET', $server = [], $files = [], $body = 'php://input', $headers = [], $cookies = [], $queryParams = [], $parsedBody = null): IntegrationTestCase
    {
        $request = new ServerRequest(
            $server,
            $files,
            $uri,
            $method,
            $body,
            $headers,
            $cookies,
            $queryParams,
            $parsedBody
        );
        $this->response = $this->app->handle($request);
        return $this;
    }

    public function assertStatusCode(int $code, $message = ''): IntegrationTestCase
    {
        if (!isset($this->response)) {
            throw new \Exception('No response has been received');
        }
        self::assertThat($this->response->getStatusCode() == $code, self::isTrue(), $message);
        return $this;
    }

    public function tearDown(): void
    {
        $this->response = null;
        chdir('..');
        parent::tearDown();
    }
}
