<?php declare(strict_types = 1);

namespace Statico\Core\Generators;

use SimpleXmlElement;
use Statico\Core\Traits\ParsesPath;
use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Generators\Sitemap;
use Zend\Config\Config;

final class XmlStringSitemap implements Sitemap
{
    use ParsesPath;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Source
     */
    protected $source;

    public function __construct(Config $config, Source $source)
    {
        $this->config = $config;
        $this->source = $source;
    }

    public function __invoke()
    {
        $documents = $this->source->all();
        $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?>\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
        foreach ($documents as $document) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->config->get('base_url') . '/' . $this->parsePath($document->getPath()));
        }
        return $xml->asXml();
    }
}
