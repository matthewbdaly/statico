<?php

declare(strict_types=1);

namespace Statico\Core\Kernel\HttpCache;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Kernel\KernelInterface;
use PublishingKit\HttpProxy\Client;
use PublishingKit\HttpProxy\Proxy;
use Psr\Cache\CacheItemPoolInterface;
use Http\Message\StreamFactory\DiactorosStreamFactory;

final class HttpCache implements KernelInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var DiactorosStreamFactory
     */
    private $factory;

    public function __construct(KernelInterface $kernel, CacheItemPoolInterface $cache)
    {
        $this->kernel = $kernel;
        $this->cache = $cache;
        $this->factory = new DiactorosStreamFactory();
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $client = new Client(function ($request) {
            return $this->kernel->handle($request);
        });
        $proxy = new Proxy($client, $this->cache, $this->factory);
        return $proxy->handle($request);
    }
}
