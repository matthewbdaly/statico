<?php declare(strict_types=1);

namespace Statico\Plugins\DynamicSitemap\Http\Controllers;

use Zend\Diactoros\Response\XmlResponse;
use Statico\Core\Contracts\Generators\Sitemap;

final class SitemapController
{
    /**
     * @var Sitemap
     */
    private $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    public function index(): XmlResponse
    {
        return new XmlResponse(
            $this->sitemap->__invoke(),
            200,
            ['Content-Type' => ['text/xml']]
        );
    }
}
