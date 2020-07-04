<?php

declare(strict_types=1);

namespace Statico\Core\Sources;

use League\Flysystem\FilesystemInterface;
use Mni\FrontYAML\Parser;
use Mni\FrontYAML\Document as ParsedDocument;
use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Objects\Document;
use Statico\Core\Objects\MarkdownDocument;
use PublishingKit\Utilities\Contracts\Collectable;
use PublishingKit\Utilities\Collections\LazyCollection;
use DateTime;

final class MarkdownFiles implements Source
{
    /**
     * @var FilesystemInterface
     */
    protected $fs;

    /**
     * @var Parser
     */
    protected $parser;

    public function __construct(FilesystemInterface $fs, Parser $parser)
    {
        $this->fs = $fs;
        $this->parser = $parser;
    }
 
    public function all(): Collectable
    {
        return LazyCollection::make(function () {
            $files = $this->fs->listContents('content://', true);
            foreach ($files as $file) {
                if ($file['type'] == 'dir') {
                    continue;
                }
                if (!preg_match('/.(markdown|md)$/', $file['path'])) {
                    continue;
                }
                if ($content = $this->fs->read('content://' . $file['path'])) {
                    yield $this->fromMarkdown($this->parser->parse($content), $file['path']);
                }
            }
        });
    }

    public function find(string $name): ?Document
    {
        // Does that page exist?
        $path = rtrim($name, '/') . '.md';
        if (!$this->fs->has("content://" . $path)) {
            return null;
        }

        // Get content
        if (!$rawcontent = $this->fs->read("content://" . $path)) {
            return null;
        }
        return $this->fromMarkdown($this->parser->parse($rawcontent), $path);
    }

    private function fromMarkdown(ParsedDocument $doc, string $path): MarkdownDocument
    {
        $document = new MarkdownDocument();
        $document->setContent($doc->getContent());
        foreach ($doc->getYAML() as $field => $value) {
            $document->setField($field, $value);
        }
        $document->setPath($path);
        $lastUpdated = new DateTime();
        $lastUpdated->setTimestamp($this->fs->getTimestamp("content://" . $path));
        $document->setUpdatedAt($lastUpdated);
        return $document;
    }
}
