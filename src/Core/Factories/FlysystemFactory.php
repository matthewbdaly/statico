<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Stash as StashStore;
use Stash\Pool;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException;

final class FlysystemFactory
{
    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    public function make(array $config)
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'local';
        }
        switch ($config['driver']) {
            case 'dropbox':
                $adapter = $this->createDropboxAdapter($config);
                break;
            default:
                $adapter = $this->createLocalAdapter($config);
                break;
        }
        $cache = new StashStore($this->pool, 'storageKey', 300);
        return new Filesystem(
            new CachedAdapter(
                $adapter,
                $cache
            )
        );
    }

    private function createLocalAdapter(array $config)
    {
        if (!isset($config['path'])) {
            throw new BadFlysystemConfigurationException('Path not set for local driver');
        }
        return new Local(BASE_DIR.'/'.$config['path']);
    }

    private function createDropboxAdapter(array $config)
    {
        if (!isset($config['token'])) {
            throw new BadFlysystemConfigurationException('Token not set for Dropbox driver');
        }
        $client = new Client($config['token']);
        return new DropboxAdapter($client);
    }
}
