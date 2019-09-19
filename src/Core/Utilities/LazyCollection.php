<?php declare(strict_types=1);

namespace Statico\Core\Utilities;

use Closure;
use Statico\Core\Contracts\Utilities\Collectable;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class LazyCollection implements Collectable, Countable, IteratorAggregate, JsonSerializable
{
    /**
     * {@inheritDoc}
     */
    public static function make(array $items)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function toJson()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function map(Closure $callback)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Closure $callback)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function reject(Closure $callback)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(Closure $callback, $initial = 0)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function pluck($name)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function each(Closure $callback)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function push($item)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function pop()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function unshift($item)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function shift()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function sort(Closure $callback = null)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function reverse()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function keys()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function values()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function chunk(int $size)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function merge($merge)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function seek($position)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function groupBy(string $key)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function flatten()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
    }
}
