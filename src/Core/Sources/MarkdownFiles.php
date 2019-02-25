<?php declare(strict_types = 1);

namespace Statico\Core\Sources;

use League\Flysystem\MountManager;
use Mni\FrontYAML\Parser;
use Statico\Core\Traits\ParsesPath;
use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Factories\DocumentFactory;

final class MarkdownFiles implements Source
{
    use ParsesPath;

    /**
     * @var MountManager
     */
    protected $manager;

    /**
     * @var Parser
     */
    protected $parser;

    public function __construct(MountManager $manager, Parser $parser)
    {
        $this->manager = $manager;
        $this->parser = $parser;
    }
 
    public function all(): array
    {
        $files = $this->manager->listContents('content://', true);
        $searchable = [];
        foreach ($files as $file) {
            if ($file['type'] == 'dir') {
                continue;
            }
            if ($content = $this->manager->read('content://'.$file['path'])) {
                $searchable[] = DocumentFactory::fromYaml($this->parser->parse($content), $file['path']);
            }
        }
        return $searchable;
    }

    public function find(string $name)
    {
        // Does that page exist?
        $path = rtrim($name, '/') . '.md';
        if (!$this->manager->has("content://".$path)) {
            return null;
        }

        // Get content
        if (!$rawcontent = $this->manager->read("content://".$path)) {
            return null;
        }
        return DocumentFactory::fromYaml($this->parser->parse($rawcontent), $path);
    }
}
