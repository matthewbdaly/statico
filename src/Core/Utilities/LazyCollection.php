<?php declare(strict_types=1);

namespace Statico\Core\Utilities;

use Closure;
use Statico\Core\Contracts\Utilities\Collectable;
use Countable;
use IteratorAggregate;
use ArrayIterator;
use JsonSerializable;
use Generator;
use Statico\Core\Utilities\Traits\Macroable;
use Traversable;

class LazyCollection implements Collectable, Countable, IteratorAggregate, JsonSerializable
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
        if ($source instanceof Closure || $source instanceof self) {
            $this->source = $source;
        } elseif (is_null($source)) {
            $this->source = static::empty();
        } else {
            $this->source = $this->getArrayableItems($source);
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function make(callable $callback)
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
            return $items->all();
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

    public function all()
    {
        if (is_array($this->source)) {
            return $this->source;
        }
        return iterator_to_array($this->getIterator());
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
        return $this->filter(function ($item) use ($callback) {
            return !$callback($item);
        });
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
}
