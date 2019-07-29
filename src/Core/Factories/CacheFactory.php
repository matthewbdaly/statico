<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Stash\Pool;
use Stash\Driver\Apc;
use Stash\Driver\BlackHole;
use Stash\Driver\Composite;
use Stash\Driver\Ephemeral;
use Stash\Driver\FileSystem;
use Stash\Driver\Memcache;
use Stash\Driver\Redis;
use Stash\Driver\Sqlite;
use Stash\Interfaces\DriverInterface;
use Zend\Config\Config;

final class CacheFactory
{
    public function make(Config $config): Pool
    {
        $driver = $this->createAdapter($config->toArray());
        return new Pool($driver);
    }

    private function createAdapter(array $config): DriverInterface
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'filesystem';
        }
        switch ($config['driver']) {
            case 'test':
                $driver = $this->createBlackHoleAdapter($config);
                break;
            case 'ephemeral':
                $driver = $this->createEphemeralAdapter($config);
                break;
            case 'composite':
                $driver = $this->createCompositeAdapter($config);
                break;
            case 'sqlite':
                $driver = $this->createSqliteAdapter($config);
                break;
            case 'apc':
                $driver = $this->createApcAdapter($config);
                break;
            case 'memcache':
                $driver = $this->createMemcacheAdapter($config);
                break;
            case 'redis':
                $driver = $this->createRedisAdapter($config);
                break;
            default:
                $driver = $this->createFilesystemAdapter($config);
                break;
        }
        return $driver;
    }

    private function createFilesystemAdapter(array $config): FileSystem
    {
        $adapterConfig = [
            'path' => isset($config['path']) ? BASE_DIR.'/'.$config['path'] : null,
        ];
        if (isset($config['dirSplit'])) {
            $adapterConfig['dirSplit'] = $config['dirSplit'];
        }
        if (isset($config['filePermissions'])) {
            $adapterConfig['filePermissions'] = $config['filePermissions'];
        }
        if (isset($config['dirPermissions'])) {
            $adapterConfig['dirPermissions'] = $config['dirPermissions'];
        }
        return new FileSystem($adapterConfig);
    }

    private function createBlackHoleAdapter(array $config): BlackHole
    {
        return new BlackHole;
    }
    
    private function createEphemeralAdapter(array $config): Ephemeral
    {
        return new Ephemeral;
    }

    private function createCompositeAdapter(array $config): Composite
    {
        $drivers = [];
        foreach ($config['subdrivers'] as $driver) {
            $drivers[] = $this->createAdapter($driver);
        }
        return new Composite([
            'drivers' => $drivers
        ]);
    }

    private function createSqliteAdapter(array $config): Sqlite
    {
        return new Sqlite([
            'extension' => isset($config['extension']) ? $config['extension'] : null,
            'version' => isset($config['version']) ? $config['version'] : null,
            'nesting' => isset($config['nesting']) ? $config['nesting'] : null,
            'path' => isset($config['path']) ? $config['path'] : null,
            'filePermissions' => isset($config['filePermissions']) ? $config['filePermissions'] : null,
            'dirPermissions' => isset($config['dirPermissions']) ? $config['dirPermissions'] : null
        ]);
    }

    private function createApcAdapter(array $config): Apc
    {
        return new Apc([
            'ttl' => isset($config['ttl']) ? $config['ttl'] : null,
            'namespace' => isset($config['namespace']) ? $config['namespace'] : null
        ]);
    }

    private function createMemcacheAdapter(array $config): Memcache
    {
        return new Memcache([
            'servers' => isset($config['servers']) ? $config['servers'] : null,
            'extension' => isset($config['extension']) ? $config['extension'] : null,
            'prefix_key' => isset($config['prefix_key']) ? $config['prefix_key'] : null,
            'libketama_compatible' => isset($config['libketama_compatible']) ? $config['libketama_compatible'] : null,
            'cache_lookups' => isset($config['cache_lookups']) ? $config['cache_lookups'] : null,
            'serializer' => isset($config['serializer']) ? $config['serializer'] : null,
        ]);
    }

    private function createRedisAdapter(array $config): Redis
    {
        return new Redis([
            'servers' => isset($config['servers']) ? $config['servers'] : null,
        ]);
    }
}
