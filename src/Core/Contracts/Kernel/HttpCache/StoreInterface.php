<?php declare(strict_types=1);

namespace Statico\Core\Contracts\Kernel\HttpCache;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface StoreInterface
{
    public function get(ServerRequestInterface $request): ?string;

    public function put(ServerRequestInterface $request, ResponseInterface $response): void;
}
