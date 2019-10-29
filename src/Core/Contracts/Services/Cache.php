<?php

namespace Statico\Core\Contracts\Services;

interface CacheContract
{
    /**
     * Get item from cache
     *
     * @param  string $key Key to set.
     * @param  mixed $default Optional default value.
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Set item in cache
     *
     * @param string $key Key to set.
     * @param mixed $value Value.
     * @param null|int|\DateTime $expiry Optional number of seconds till expiry, or DateTime to expire
     */
    public function put(string $key, $value, $expiry = null): void;

    /**
     * Set item in cache forever
     *
     * @param string $key Key to set.
     * @param mixed $value Value.
     */
    public function forever(string $key, $value): void;

    /**
     * Forget item from cache
     *
     * @param string $key Key to set.
     */
    public function forget(string $key): void;

    /**
     * Is key set?
     */
    public function has(string $key): bool;

    /**
     * Remember a value
     *
     * @param  string $key Key to set.
     * @param  int $seconds Seconds to expiry.
     * @param  int|\DateTime $expiry Number of seconds till expiry, or DateTime to expire
     * @param  callable $callback Callback to execute to retrieve value.
     * @return mixed
     */
    public function remember(string $key, $expiry, callable $callback);

    /**
     * Remember a value forever
     *
     * @param  string $key Key to set.
     * @param  callable $callback Callback to execute to retrieve value.
     * @return mixed
     */
    public function rememberForever(string $key, callable $callback);

    /**
     * Flush cache
     */
    public function flush(): void;
}
