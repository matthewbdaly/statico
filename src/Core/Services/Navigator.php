<?php

declare(strict_types=1);

namespace Statico\Core\Services;

use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Objects\Navigation\Container;
use Statico\Core\Objects\Navigation\Page;
use Statico\Core\Utilities\Collection;

final class Navigator
{
    /**
     * @var Source
     */
    private $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function __invoke(): Container
    {
        $items = $this->source->all()
            ->filter(function ($item) {
                return $item->getField('navigation');
            })->toArray();
        $items = Collection::make($items)->map(function ($item) {
            return [
                'label' => $item->getField('title'),
                'uri' => $item->getUrl(),
                'pages' => [],
            ];
        })->sort(function ($a, $b) {
            return count(explode("/", $a['uri'])) > count(explode("/", $b['uri']));
        })->reduce(function ($result, $item) {
            return $this->sortByParent($result, $item);
        }, []);
        return Container::make($items);
    }

    private function sortByParent(array $result, array $item): array
    {
        foreach ($result as $k => &$parent) {
            if ($this->isParent($parent, $item)) {
                $parent['pages'][] = $item;
                return $result;
            }
            if (count($parent['pages']) > 0) {
                $parent['pages'] = $this->sortByParent($parent['pages'], $item);
                return $result;
            }
        }
        $result[] = $item;
        return $result;
    }

    private function isParent(array $parent, array $child): bool
    {
        if ($child === $parent) {
            return false;
        }
        $path = explode("/", $child['uri']);
        array_shift($path);
        array_pop($path);
        $parentPath = explode("/", $parent['uri']);
        array_shift($parentPath);
        return $parentPath == $path;
    }
}
