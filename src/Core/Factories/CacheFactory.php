<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Stash\Pool;
use Stash\Driver\FileSystem;

final class CacheFactory
{
    public static function make(array $config): Pool
    {
        $driver = new FileSystem;
        return new Pool($driver);
    }
}
