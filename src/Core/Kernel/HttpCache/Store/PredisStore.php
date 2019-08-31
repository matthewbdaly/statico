<?php declare(strict_types=1);

namespace Statico\Core\Kernel\HttpCache\Store;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Predis\Client;
use Statico\Core\Contracts\Kernel\HttpCache\StoreInterface;

final class PredisStore implements StoreInterface
{
    /**
     * @var Client
     */
    private $predis;

    public function __construct(Client $predis)
    {
        $this->predis = $predis;
    }

    public function get(ServerRequestInterface $request): ?string
    {
        $key = $this->getCacheKey($request);
        if ($this->predis->exists($key)) {
            return $this->predis->get($key);
        }
        return null;
    }

    public function put(ServerRequestInterface $request, ResponseInterface $response): void
    {
        $key = $this->getCacheKey($request);
        $this->predis->set($key, $response->getBody()->__toString());
        $this->predis->expire($key, 3600);
    }

    private function getCacheKey(ServerRequestInterface $request)
    {
        $uri = $request->getUri();
        return 'cached-'
            . trim($uri->getPath(), '/')
            . ($uri->getQuery() ? '?' . $uri->getQuery() : '')
            . '.html';
    }
}
