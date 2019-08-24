<?php declare(strict_types=1);

namespace Statico\Core\Factories;

use Statico\Core\Objects\Document;
use Mni\FrontYAML\Document as YamlDocument;

final class DocumentFactory
{
    public static function fromYaml(YamlDocument $doc, string $path): Document
    {
        $document = new Document();
        $document->setContent($doc->getContent());
        foreach ($doc->getYAML() as $field => $value) {
            $document->setField($field, $value);
        }
        $document->setPath($path);
        return $document;
    }
}
