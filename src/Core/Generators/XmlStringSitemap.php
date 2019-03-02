<?php declare(strict_types = 1);

namespace Statico\Core\Generators;

use SimpleXmlElement;
use Statico\Core\Traits\ParsesPath;
use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Generators\Sitemap;

final class XmlStringSitemap implements Sitemap
{
    use ParsesPath;

    /**
     * @var Source
     */
    protected $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    public function __invoke()
    {
        $documents = $this->source->all();
        $xml = new SimpleXmlElement('<xml />');
        $urlset = $xml->addChild('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
');
        foreach ($documents as $document) {
            $item = $urlset->addChild('<url>');
            $item->addChild('loc', $this->parsePath($document->getPath()));
        }
        return $xml->asXml();
    }
}
