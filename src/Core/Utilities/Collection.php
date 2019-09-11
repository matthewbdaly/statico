<?php declare(strict_types=1);

namespace Statico\Core\Utilities;

use Closure;
use Countable;
use ArrayAccess;
use SeekableIterator;
use JsonSerializable;
use Serializable;
use Statico\Core\Contracts\Utilities\Collectable;
use Statico\Core\Utilities\Traits\Macroable;
use OutOfBoundsException;

/**
 * Collection class
 */
class Collection implements Countable, ArrayAccess, SeekableIterator, JsonSerializable, Collectable, Serializable
{
    use Macroable;

    /**
     * Items
     *
     * @var array
     */
    protected $items;

    /**
     * Position
     *
     * @var integer
     */
    protected $position = 0;

    /**
     * Return count of items
     *
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Constructor
     *
     * @param array $items Items to collect.
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create collection
     *
     * @param array $items Items to collect.
     * @return Collection
     */
    public static function make(array $items)
    {
        return new static($items);
    }

    /**
     * Does item exist?
     *
     * @param mixed $offset The offset.
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Get offset
     *
     * @param mixed $offset The offset.
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * Set offset
     *
     * @param mixed $offset The offset.
     * @param mixed $value  The value to set.
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
            return;
        }
        $this->items[$offset] = $value;
    }

    /**
     * Unset offset
     *
     * @param mixed $offset The offset.
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * Get current item
     *
     * @return mixed
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * Get key for current item
     *
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Move counter to next item
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Move counter back to zero
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Is current item valid?
     *
     * @return boolean
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Serialize collection to JSON
     *
     * @return string|false
     */
    public function jsonSerialize()
    {
        return json_encode($this->items);
    }

    /**
     * Convert collection to JSON
     *
     * @return string|false
     */
    public function toJson()
    {
        return $this->jsonSerialize();
    }

    /**
     * Convert collection to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Map operation
     *
     * @param Closure $callback The callback to use.
     * @return Collection
     */
    public function map(Closure $callback)
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * Filter operation
     *
     * @param Closure $callback The callback to use.
     * @return Collection
     */
    public function filter(Closure $callback)
    {
        return new static(array_filter($this->items, $callback));
    }

    /**
     * Reverse filter operation
     *
     * @param Closure $callback The callback to use.
     * @return Collection
     */
    public function reject(Closure $callback)
    {
        return $this->filter(function ($item) use ($callback) {
            return !$callback($item);
        });
    }

    /**
     * Reduce operation
     *
     * @param Closure $callback The callback to use.
     * @param mixed   $initial  The initial value.
     * @return mixed
     */
    public function reduce(Closure $callback, $initial = 0)
    {
        $accumulator = $initial;
        foreach ($this->items as $item) {
            $accumulator = $callback($accumulator, $item);
        }
        return $accumulator;
    }

    /**
     * Pluck a single field
     *
     * @param mixed $name Name of field to pluck.
     * @return mixed
     */
    public function pluck($name)
    {
        return $this->map(function ($item) use ($name) {
            return $item[$name];
        });
    }

    /**
     * Apply callback to each item in the collection
     *
     * @param Closure $callback The callback to use.
     * @return void
     */
    public function each(Closure $callback)
    {
        foreach ($this->items as $item) {
            $callback($item);
        }
    }

    /**
     * Push item to end of collection
     *
     * @param mixed $item Item to push.
     * @return Collection
     */
    public function push($item)
    {
        array_push($this->items, $item);
        return new static($this->items);
    }

    /**
     * Pop item from end of collection
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push item to start of collection
     *
     * @param mixed $item Item to push.
     * @return Collection
     */
    public function unshift($item)
    {
        array_unshift($this->items, $item);
        return new static($this->items);
    }

    /**
     * Pop item from start of collection
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Sort collection
     *
     * @param Closure|null $callback The callback to use.
     * @return Collection
     */
    public function sort(Closure $callback = null)
    {
        if ($callback) {
            usort($this->items, $callback);
        } else {
            sort($this->items);
        }
        return new static($this->items);
    }

    /**
     * Reverse collection
     *
     * @return Collection
     */
    public function reverse()
    {
        return new static(array_reverse($this->items));
    }

    /**
     * Return keys
     *
     * @return Collection
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * Return values
     *
     * @return Collection
     */
    public function values(): Collection
    {
        return new static(array_values($this->items));
    }

    /**
     * Return chunked collection
     *
     * @param integer $size Chunk size.
     * @return Collection
     */
    public function chunk(int $size): Collection
    {
        return new static(array_chunk($this->items, $size));
    }

    /**
     * Merge another array into the collection
     *
     * @param mixed $merge Array to merge.
     * @return Collection
     */
    public function merge($merge): Collection
    {
        return new static(array_merge($this->items, $merge));
    }

    /**
     * Seek a position
     *
     * @param mixed $position Position to seek.
     * @return void
     * @throws OutOfBoundsException Invalid position.
     */
    public function seek($position)
    {
        if (!isset($this->items[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }
        $this->position = $position;
    }

    /**
     * Group by a given key
     *
     * @param string $key Key to group by.
     * @return Collection
     */
    public function groupBy(string $key): Collection
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$item[$key]][] = $item;
        }
        return new static($items);
    }

    /**
     * Flatten items
     *
     * @return Collection
     */
    public function flatten(): Collection
    {
        $return = [];
        array_walk_recursive($this->items, function ($a) use (&$return) {
            $return[] = $a;
        });
        return new static($return);
    }

    /**
     * Paginate items
     *
     * @return Collection
     */
    public function paginate(int $perPage, int $page): Collection
    {
        $offset = ($page - 1) * $perPage;
        return new static(array_slice($this->items, $offset, $perPage));
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->items = unserialize($serialized);
    }

    public function pipe(callable $callback)
    {
        return $callback($this);
    }

    public function sortByParent(callable $callback)
    {
        $branch = [];
        foreach ($this->items as $item) {
            foreach ($this->items as $item2) {
                if ($item === $item2) {
                    continue;
                }
                if ($callback($item2, $item)) {
                    eval(\Psy\Sh());
                    if (!isset($item->children)) {
                        $item->children = [];
                    }
                    $item->children[] = $item2;
                }
            }
            $branch[] = $item;
        }
        return new static($branch);
    }
}
