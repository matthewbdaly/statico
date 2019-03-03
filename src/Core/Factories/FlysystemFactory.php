<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

final class FlysystemFactory
{
    public function make(array $config)
    {
        return new Filesystem(
            new Local(BASE_DIR.'/'.$config['path'])
        );
    }
}
