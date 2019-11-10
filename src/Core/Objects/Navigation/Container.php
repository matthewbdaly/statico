<?php

declare(strict_types=1);

namespace Statico\Core\Objects\Navigation;

use TypeError;
use Statico\Core\Utilities\Collection;

final class Container extends Collection
{
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if (!is_a($item, Page::class)) {
                throw new TypeError('Items passed to Container must be Page instances');
            }
        }
        $this->items = $items;
    }

    public static function make(array $items): Collection
    {
        $pages = [];
        foreach ($items as $item) {
            $pages[] = Page::make($item);
        }
        return new static($pages);
    }

    public function toArray(): array
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->toArray();
        }
        return $data;
    }
}
