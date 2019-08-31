<?php declare(strict_types=1);

namespace Statico\Core\Kernel\HttpCache;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Kernel\KernelInterface;
use Statico\Core\Contracts\Kernel\StoreInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class HttpCache implements KernelInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var StoreInterface
     */
    private $store;

    public function __construct(KernelInterface $kernel, StoreInterface $store)
    {
        $this->kernel = $kernel;
        $this->store = $store;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // check if request can be cached
        if ($request->getMethod() != 'GET') {
            return $this->kernel->handle($request);
        }

        // return early if page is cached
        if ($html = $this->getCachedHtml($request)) {
            return new HtmlResponse($html);
        }

        //
        $response = $this->kernel->handle($request);

        // check if response can be cached
        if ($response->getStatusCode() == 200) {
            $this->cacheResponse($request, $response);
        }

        return $response;
    }

    private function getCachedHtml(ServerRequestInterface $request): string
    {
        return $this->store->get($request);
    }

    private function cacheResponse(ServerRequestInterface $request, ResponseInterface $response): void
    {
        $this->store->put($request, $response);
    }
}
