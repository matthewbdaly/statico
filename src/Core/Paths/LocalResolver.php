<?php declare(strict_types = 1);

namespace Statico\Core\Paths;

use Statico\Core\Contracts\Paths\Resolver;

final class LocalResolver implements Resolver
{
    public function resolve(string $name): ?string
    {
        $filename = BASE_DIR.CONTENT_PATH. rtrim($name, '/') . '.md';
        if (!file_exists($filename)) {
            return null;
        }
        return $filename;
    }

    public function index(): array
    {
        $root = BASE_DIR.CONTENT_PATH;
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
