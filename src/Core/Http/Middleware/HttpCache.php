<?php

declare(strict_types=1);

namespace Statico\Core\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HttpCache implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $cacheableStatus = [200, 304];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (getenv('APP_ENV') === 'development') {
            return $response;
        }

        if ($request->getMethod() != 'GET' || !in_array($response->getStatusCode(), $this->cacheableStatus)) {
            return $response;
        }

        $maxLifetime = 3600; // cache for 1 hour
        return $response->withAddedHeader(
            'Expires',
            gmdate("D, d M Y H:i:s", time() + $maxLifetime) . " GMT"
        );
    }
}
