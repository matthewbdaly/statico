<?php declare(strict_types=1);

namespace Statico\Core\Services;

use Zend\Navigation\Navigation;
use Statico\Core\Contracts\Sources\Source;

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

    public function __invoke(): Navigation
    {
        $items = $this->source->all()
            ->sort(function ($a, $b) {
                return count(explode("/", $a->getPath())) > count(explode("/", $b->getPath()));
            })->sortByParent(function ($child, $parent) {
                $path = explode("/", $child->getPath());
                array_pop($path);
                return $path == $parent->getPath();
            })->map(function ($item) {
                return [
                    'label' => $item->getField('title'),
                    'uri' => $item->getUrl()
                ];
            })->toArray();
        return new Navigation($items);
    }
}
