<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Stash\Pool;
use Stash\Driver\FileSystem;

final class CacheFactory
{
    public function make(array $config): Pool
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            default:
                $driver = $this->createFilesystemAdapter($config);
                break;
        }
        return new Pool($driver);
    }

    private function createFilesystemAdapter(array $config): FileSystem
    {
        return new FileSystem([
            'path' => isset($config['path']) ? $config['path'] : null
        ]);
    }
}
