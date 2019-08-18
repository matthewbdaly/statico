<?php declare(strict_types = 1);

namespace Statico\Plugins\DynamicSitemap\Http\Controllers;

use Zend\Diactoros\Response\XmlResponse;
use Statico\Core\Generators\XmlStringSitemap;

final class SitemapController
{
    /**
     * @var XmlStringSitemap
     */
    private $sitemap;

    public function __construct(XmlStringSitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    public function index()
    {
        return new XmlResponse(
            $this->sitemap->__invoke(),
            200,
            ['Content-Type' => ['application/hal+xml']]
        );
    }
}
