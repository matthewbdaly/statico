<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;

final class FlysystemFactory
{
    public static function create(array $config)
    {
        return new Local(BASE_DIR.'/'.$config['path']);
    }
}
