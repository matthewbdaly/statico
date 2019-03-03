<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;

final class FlysystemFactory
{
    public static function create()
    {
        return new Local(BASE_DIR.'/content');
    }
}
