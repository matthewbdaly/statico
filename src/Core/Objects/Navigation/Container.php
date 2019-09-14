<?php declare(strict_types=1);

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
}
