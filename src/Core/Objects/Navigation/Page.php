<?php

declare(strict_types=1);

namespace Statico\Core\Objects\Navigation;

use Exception;

final class Page
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

    public function __toString()
    {
        $response = "";
        if ($this->pages) {
            $response .= "<li class=\"dropdown\">";
            $response .= "<a href='{$this->uri}'>{$this->label}</a>";
            $response .= "<div class=\"dropdown-content\">";
            foreach ($this->pages as $page) {
                $response .= $page->__toString();
            }
            $response .= "</div";
        } else {
            $response .= "<li>";
            $response .= "<a href='{$this->uri}'>{$this->label}</a>";
        }
        $response .= "</li>";
        return $response;
    }
}
