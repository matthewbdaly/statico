<?php declare(strict_types = 1);

namespace Statico\Core\Views\Helpers;

final class Version
{
    public function __invoke(string $path): string
    {
        return $path."?v=".filemtime($path);
    }
}
