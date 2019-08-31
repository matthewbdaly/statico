<?php declare(strict_types=1);

namespace Statico\Core\Kernel\HttpCache\Store;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Kernel\HttpCache\StoreInterface;

final class FileStore implements StoreInterface
{
    /**
     * @var string
     */
    private $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function get(ServerRequestInterface $request): ?string
    {
        $fullPath = $this->cacheDir . '/' . $this->getCacheFile($request);
        if (file_exists($fullPath) && filemtime($fullPath) > time() - 4 * 3600) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    public function put(ServerRequestInterface $request, ResponseInterface $response): void
    {
        $cacheFilePath = $this->cacheDir . '/' . $this->getCacheFile($request);
        if (!file_exists(dirname($cacheFilePath))) {
            mkdir(dirname($cacheFilePath), 0777, true);
        }
        file_put_contents($cacheFilePath, $response->getBody()->__toString());
    }

    private function getCacheFile(ServerRequestInterface $request)
    {
        $uri = $request->getUri();
        return 'cached-'
            . trim($uri->getPath(), '/')
            . ($uri->getQuery() ? '?' . $uri->getQuery() : '')
            . '.html';
    }
}
