<?php declare(strict_types=1);

namespace Statico\Core\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ETag implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if (getenv('APP_ENV') === 'development') {
            return $response;
        }
        $method = $request->getMethod();

        // If this was not a GET or HEAD request, just return
        if ($method != 'GET' && $method != 'HEAD') {
            return $response;
        }
        $etag = md5($response->getBody()->getContents());
        $requestEtag = str_replace('"', '', $request->getHeader('if-none-match'));

        // Check to see if Etag has changed
        if ($requestEtag && $requestEtag[0] == $etag) {
            return $response->withStatus(304);
        }

        // Set Etag
        return $response->withAddedHeader('etag', $etag);
    }
}
