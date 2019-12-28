<?php

declare(strict_types=1);

namespace Statico\Core\Views\Filters;

use Exception;

final class Mix
{
    public function __invoke(string $path): string
    {
        $manifest = json_decode(file_get_contents(PUBLIC_DIR . DIRECTORY_SEPARATOR . 'mix-manifest.json'), true);
        if (! array_key_exists("/" . $path, $manifest)) {
            throw new Exception(
                "Unable to locate Mix file: {$path}"
            );
        }
        if (!file_exists(PUBLIC_DIR . DIRECTORY_SEPARATOR . $path)) {
            throw new Exception('Included file does not exist');
        }
        return $manifest["/" . $path];
    }
}
