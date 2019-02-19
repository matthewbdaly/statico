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
}
