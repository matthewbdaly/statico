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
        if (is_array($this->source)) {
            return $this->source;
        }
        return iterator_to_array($this->source);
    }

    /**
     * {@inheritDoc}
     */
    public function map(Closure $callback)
    {
        return new static(function () use ($callback) {
            foreach ($this as $key => $value) {
                yield $key => $callback($value, $key);
            }
        });
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Closure $callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($value) {
                return (bool) $value;
            };
        }
        return new static(function () use ($callback) {
            foreach ($this as $key => $value) {
                if ($callback($value, $key)) {
                    yield $key => $value;
                }
            }
        });
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
        $result = $initial;
        foreach ($this as $value) {
            $result = $callback($result, $value);
        }
        return $result;
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
