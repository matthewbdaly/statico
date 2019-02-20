<?php declare(strict_types = 1);

namespace Statico\Core\Sources;

use League\Flysystem\MountManager;
use Mni\FrontYAML\Parser;
use Statico\Core\Traits\ParsesPath;
use Statico\Core\Contracts\Sources\Source;

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
 
    public function __invoke(): array
    {
        $files = $this->manager->listContents('content://', true);
        $searchable = [];
        foreach ($files as $file) {
            if ($file['type'] == 'dir') {
                continue;
            }
            if ($content = $this->manager->read('content://'.$file['path'])) {
                $document = $this->parser->parse($content);
                $searchable[] = [
                    'title' => $document->getYAML()['title'],
                    'path' => $this->parsePath($file['path'])
                ];
            }
        }
        return $searchable;
    }
}