<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Stash as StashStore;
use Stash\Pool;

final class FlysystemFactory
{
    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    public function make(array $config)
    {
        $cache = new StashStore($this->pool, 'storageKey', 300);
        return new Filesystem(
            new CachedAdapter(
                new Local(BASE_DIR.'/'.$config['path']),
                $cache
            )
        );
    }
}
