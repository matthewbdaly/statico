<?php declare(strict_types = 1);

namespace Statico\Core\Paths;

use Statico\Core\Contracts\Paths\Resolver;
use Statico\Core\Contracts\Paths\Path;

final class LocalResolver implements Resolver
{
    /**
     * @var Path
     */
    protected $path;

    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    public function resolve(string $name): ?string
    {
        $filename = $this->path->get(). rtrim($name, '/') . '.md';
        if (!file_exists($filename)) {
            return null;
        }
        return $filename;
    }

    public function index(): array
    {
        $root = $this->path->get();
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root)
        );
        $contentFiles = [];
        foreach ($iterator as $item) {
            if ($item->getType() == 'dir') {
                continue;
            }
            $contentFiles[] = $item;
        }
        return $contentFiles;
    }
}
