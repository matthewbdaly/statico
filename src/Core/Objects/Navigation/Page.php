<?php

declare(strict_types=1);

namespace Statico\Core\Objects\Navigation;

use Exception;
use IteratorAggregate;
use ArrayIterator;

final class Page implements IteratorAggregate
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $pages;

    public function __construct(string $label, string $uri, array $pages = [])
    {
        $this->label = $label;
        $this->uri = $uri;
        $pageItems = [];
        foreach ($pages as $page) {
            $pageItems[] = Page::make($page);
        }
        $this->pages = $pageItems;
    }

    public static function make(array $item): Page
    {
        if (!isset($item['label']) || !isset($item['uri']) || !isset($item['pages'])) {
            throw new Exception('Incorrect array passed to static factory method');
        }
        return new static($item['label'], $item['uri'], $item['pages']);
    }

    public function toArray(): array
    {
        $data = [];
        $data['label'] = $this->label;
        $data['uri'] = $this->uri;
        $data['pages'] = [];
        foreach ($this->pages as $page) {
            $data['pages'][] = $page->toArray();
        }
        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this);
    }
}
