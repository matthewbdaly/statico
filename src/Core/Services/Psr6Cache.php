<?php

namespace Statico\Core\Services\Cache;

use Statico\Core\Contracts\Services\CacheContract;
use Psr\Cache\CacheItemPoolInterface;
use TypeError;

final class Psr6Cache implements CacheContract
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, $default = null)
    {
        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            return $default;
        }
        return $item->get();
    }

    /**
     * {@inheritDoc}
     */
    public function put(string $key, $value, $expiry = null): void
    {
        if (isset($expiry) && !is_int($expiry) && !is_a($expiry, 'DateTime')) {
            throw new TypeError('Expiry can only be null, an instance of DateTime, or an integer');
        }
        $item = $this->cache->getItem($key);
        $item->set($value);
        if (is_int($expiry)) {
            $item->expiresAfter($expiry);
        }
        if (is_a($expiry, 'DateTime')) {
            $item->expiresAt($expiry);
        }
        $this->cache->save($item);
    }

    /**
     * {@inheritDoc}
     */
    public function forever(string $key, $value): void
    {
        $item = $this->cache->getItem($key);
        $item->set($value);
        $this->cache->save($item);
    }

    /**
     * {@inheritDoc}
     */
    public function forget(string $key): void
    {
        $this->cache->deleteItem($key);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key): bool
    {
        $item = $this->cache->getItem($key);
        return $item->isHit();
    }

    /**
     * {@inheritDoc}
     */
    public function remember(string $key, $expiry, callable $callback)
    {
        if (!is_int($expiry) && !is_a($expiry, 'DateTime')) {
            throw new TypeError('Expiry can only be an instance of DateTime, or an integer');
        }
        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            $value = $callback();
            $item->set($value);
            if (is_int($expiry)) {
                $item->expiresAfter($expiry);
            }
            if (is_a($expiry, 'DateTime')) {
                $item->expiresAt($expiry);
            }
            $this->cache->save($item);
            return $value;
        }
        return $item->get();
    }

    /**
     * {@inheritDoc}
     */
    public function rememberForever(string $key, callable $callback)
    {
        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            $value = $callback();
            $item->set($value);
            $this->cache->save($item);
            return $value;
        }
        return $item->get();
    }

    /**
     * {@inheritDoc}
     */
    public function flush(): void
    {
        $this->cache->clear();
    }
}
