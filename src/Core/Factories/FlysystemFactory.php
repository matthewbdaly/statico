<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Stash as StashStore;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use Stash\Pool;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

final class FlysystemFactory
{
    /**
     * @var Pool
     */
    private $pool;

    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    public function make(array $config): Filesystem
    {
        if (!isset($config['driver'])) {
            $config['driver'] = 'local';
        }
        switch ($config['driver']) {
            case 'dropbox':
                $adapter = $this->createDropboxAdapter($config);
                break;
            case 'azure':
                $adapter = $this->createAzureAdapter($config);
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

    private function createLocalAdapter(array $config): Local
    {
        if (!isset($config['path'])) {
            throw new BadFlysystemConfigurationException('Path not set for local driver');
        }
        return new Local(BASE_DIR.'/'.$config['path']);
    }

    private function createDropboxAdapter(array $config): DropboxAdapter
    {
        if (!isset($config['token'])) {
            throw new BadFlysystemConfigurationException('Token not set for Dropbox driver');
        }
        $client = new Client($config['token']);
        return new DropboxAdapter($client);
    }

    private function createAzureAdapter(array $config): AzureBlobStorageAdapter
    {
        if (!isset($config['container'])) {
            throw new BadFlysystemConfigurationException('Container not set for Azure driver');
        }
        if (!isset($config['name'])) {
            throw new BadFlysystemConfigurationException('Account name not set for Azure driver');
        }
        if (!isset($config['key'])) {
            throw new BadFlysystemConfigurationException('Account key not set for Azure driver');
        }
        $endpoint = sprintf(
            'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
            $config['name'],
            $config['key']
        );
        $client = BlobRestProxy::createBlobService($endpoint);
        return new AzureBlobStorageAdapter($client, $config['container']);
    }
}
