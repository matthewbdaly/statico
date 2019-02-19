<?php declare(strict_types = 1);

namespace Statico\Core\Utilities;

use Statico\Core\Contracts\Extension\Plugin;

final class PluginCollection extends Collection
{
    /**
     * Constructor
     *
     * @param array $items Items to collect.
     * @return void
     */
    public function __construct(Plugin ...$items)
    {
        $this->items = $items;
    }

    /**
     * Create collection
     *
     * @param array $items Items to collect.
     * @return Collection
     */
    public static function make(Plugin ...$items)
    {
        return new static($items);
    }
}
