<?php declare(strict_types = 1);

namespace Statico\Core\Views\Helpers;

final class Version
{
    public function __invoke(string $path): string
    {
        return DIRECTORY_SEPARATOR.$path."?v=".filemtime(PUBLIC_DIR.DIRECTORY_SEPARATOR.$path);
    }
}
