<?php

declare(strict_types=1);

namespace Statico\Core\Generators;

use DOMDocument;
use SimpleXMLElement;
use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Generators\Sitemap;
use PublishingKit\Config\Config;

final class XmlStringSitemap implements Sitemap
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Source
     */
    private $source;

    public function __construct(Config $config, Source $source)
    {
        $this->config = $config;
        $this->source = $source;
    }

    public function __invoke(): string
    {
        $documents = $this->source->all();
        $xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?>\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
        foreach ($documents as $document) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->config->get('base_url') . $document->getUrl());
        }
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        if ($content = $xml->asXML()) {
            $doc->loadXML($content);
        }
        return $doc->saveXML();
    }
}
