<?php declare(strict_types = 1);

namespace Statico\Core\Utilities;

use Matthewbdaly\Proper\Traits\IsCollection;
use Matthewbdaly\Proper\Contracts\Collectable;
use Countable;
use ArrayAccess;
use SeekableIterator;
use JsonSerializable;

final class PluginCollection implements Collectable, Countable, ArrayAccess, SeekableIterator, JsonSerializable
{
    use IsCollection;

    /**
     * Constructor
     *
     * @param array $items Items to collect.
     * @return void
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Create collection
     *
     * @param array $items Items to collect.
     * @return Collectable
     */
    public static function make(array $items)
    {
        return new static($items);
    }
}
