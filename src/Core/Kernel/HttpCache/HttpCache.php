<?php

declare(strict_types=1);

namespace Statico\Core\Kernel\HttpCache;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Kernel\KernelInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Statico\Core\Contracts\Kernel\HttpCache\StoreInterface;

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
        if ($html = $this->store->get($request)) {
            return new HtmlResponse($html);
        }

        $response = $this->kernel->handle($request);

        // check if response can be cached
        $nocache = $response->getHeader('Cache-Control');
        if (count($nocache) && (strtolower($nocache[0]) == 'no-cache' || strtolower($nocache[0] == 'no-store'))) {
            return $response;
        }

        if ($response->getStatusCode() == 200) {
            $this->store->put($request, $response);
        }

        return $response;
    }
}
