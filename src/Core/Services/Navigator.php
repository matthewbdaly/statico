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
            ->map(function ($item) {
                return [
                    'label' => $item->getField('title'),
                    'uri' => $item->getUrl()
                ];
            })->toArray();
        return new Navigation($items);
    }
}