<?php declare(strict_types = 1);

namespace Statico\Core\Traits;

trait ParsesPath
{
    protected function parsePath(string $path): ?string
    {
        return preg_replace('/.(markdown|md)$/', '/', $path);
    }
}
