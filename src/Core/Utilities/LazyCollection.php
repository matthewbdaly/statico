<?php

declare(strict_types=1);

namespace Statico\Core\Utilities;

use Statico\Core\Contracts\Utilities\Collectable;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use JsonSerializable;
use Generator;
use Statico\Core\Utilities\Traits\Macroable;
use Traversable;
use Serializable;

class LazyCollection implements Collectable, Countable, IteratorAggregate, JsonSerializable, Serializable
{
    use Macroable;

    /**
     * @var callable|static
     */
    private $source;

    /**
     * Create a new lazy collection instance.
     *
     * @param  mixed  $source
     * @return void
     */
    public function __construct($source = null)
    {
        if (is_callable($source) || $source instanceof self) {
            $this->source = $source;
        } elseif (is_null($source)) {
            $this->source = static::empty();
        } else {
            $this->source = $this->getArrayableItems($source);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return self
     */
    public static function make(callable $callback): self
    {
        return new static($callback);
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param  mixed  $items
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof Collectable) {
            return $items->toArray();
        } elseif ($items instanceof JsonSerializable) {
            return (array) $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }
        return (array) $items;
    }

    /**
     * {@inheritDoc}
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->map(function ($value) {
            return $value instanceof Collectable ? $value->toArray() : $value;
        })->all();
    }

    /**
     * @return array
     *
     * @psalm-return array<int|mixed, mixed>
     */
    public function all(): array
    {
        if (is_array($this->source)) {
            return $this->source;
        }
        return iterator_to_array($this->getIterator());
    }

    /**
     * {@inheritDoc}
     */
    public function map(callable $callback)
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
    public function filter(callable $callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($value): bool {
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
    public function reject(callable $callback)
    {
        return $this->filter(function ($item) use ($callback) {
            return !$callback($item);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function reduce(callable $callback, $initial = 0)
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
        return $this->map(function ($item) use ($name) {
            return $item[$name];
        });
    }

    /**
     * {@inheritDoc}
     */
    public function each(callable $callback)
    {
        foreach ($this->source as $item) {
            $callback($item);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return iterator_count($this->getIterator());
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return $this->makeIterator($this->source);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
    }

    /**
     * Make an iterator from the given source.
     *
     * @param  mixed  $source
     * @return \Traversable
     */
    protected function makeIterator($source)
    {
        if ($source instanceof IteratorAggregate) {
            return $source->getIterator();
        }
        if (is_array($source)) {
            return new ArrayIterator($source);
        }
        return $source();
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->source = unserialize($serialized);
    }
}
