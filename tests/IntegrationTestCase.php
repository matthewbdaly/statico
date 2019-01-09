<?php declare(strict_types = 1);

namespace Tests;

use Zend\Diactoros\ServerRequest;

class IntegrationTestCase extends TestCase
{
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

    public function assertStatusCode(int $code, $message = ''): void
    {
        if (!isset($this->response)) {
            throw new \Exception('No response has been received');
        }
        self::assertThat($this->response->getStatusCode() == $code, self::isTrue(), $message);
    }

    public function tearDown(): void
    {
        $this->response = null;
        parent::tearDown();
    }
}
