<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Stash\Pool;
use Stash\Driver\Apc;
use Stash\Driver\FileSystem;
use Stash\Driver\Sqlite;

final class CacheFactory
{
    public function make(array $config): Pool
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            case 'sqlite':
                $driver = $this->createSqliteAdapter($config);
                break;
            case 'apc':
                $driver = $this->createApcAdapter($config);
                break;
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

    private function createSqliteAdapter(array $config): Sqlite
    {
        return new Sqlite([
            'path' => isset($config['path']) ? $config['path'] : null
        ]);
    }

    private function createApcAdapter(array $config): Apc
    {
        return new Apc([
            'ttl' => isset($config['ttl']) ? $config['ttl'] : null,
            'namespace' => isset($config['namespace']) ? $config['namespace'] : null
        ]);
    }
}
