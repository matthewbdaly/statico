<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Memory\MemoryAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Stash as StashStore;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Adapter\Ftp as FTPAdapter;
use Stash\Pool;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use Aws\S3\S3Client;

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
            case 'memory':
                $adapter = $this->createMemoryAdapter($config);
                break;
            case 'dropbox':
                $adapter = $this->createDropboxAdapter($config);
                break;
            case 'azure':
                $adapter = $this->createAzureAdapter($config);
                break;
            case 's3':
                $adapter = $this->createS3Adapter($config);
                break;
            case 'sftp':
                $adapter = $this->createSftpAdapter($config);
                break;
            case 'ftp':
                $adapter = $this->createFtpAdapter($config);
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

    private function createMemoryAdapter(array $config): MemoryAdapter
    {
        return new MemoryAdapter();
    }

    private function createLocalAdapter(array $config): Local
    {
        if (!isset($config['path'])) {
            throw new BadFlysystemConfigurationException('Path not set for local driver');
        }
        return new Local(BASE_DIR . '/' . $config['path']);
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

    private function createS3Adapter(array $config): AwsS3Adapter
    {
        if (!isset($config['bucket'])) {
            throw new BadFlysystemConfigurationException('Bucket not set for S3 driver');
        }
        if (!isset($config['key'])) {
            throw new BadFlysystemConfigurationException('Key not set for S3 driver');
        }
        if (!isset($config['secret'])) {
            throw new BadFlysystemConfigurationException('Secret not set for S3 driver');
        }
        if (!isset($config['region'])) {
            throw new BadFlysystemConfigurationException('Region not set for S3 driver');
        }
        if (!isset($config['version'])) {
            throw new BadFlysystemConfigurationException('Version not set for S3 driver');
        }
        $client = new S3Client([
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
            'region' => $config['region'],
            'version' => $config['version'],
        ]);
        return new AwsS3Adapter($client, $config['bucket']);
    }

    private function createSftpAdapter(array $config): SftpAdapter
    {
        if (!isset($config['host'])) {
            throw new BadFlysystemConfigurationException('Host not set for SFTP driver');
        }
        if (!isset($config['username'])) {
            throw new BadFlysystemConfigurationException('Username not set for SFTP driver');
        }
        if (!isset($config['password']) && !isset($config['privatekey'])) {
            throw new BadFlysystemConfigurationException('Neither password nor private key set for SFTP driver');
        }
        return new SftpAdapter([
            'host' => $config['host'],
            'port' => isset($config['port']) ? $config['port'] : 22,
            'username' => $config['username'],
            'password' => $config['password'],
            'privateKey' => isset($config['privatekey']) ? $config['privatekey'] : null,
            'root' => isset($config['root']) ? $config['root'] : null,
            'timeout' => isset($config['timeout']) ? $config['timeout'] : 10,
        ]);
    }

    private function createFtpAdapter(array $config): FTPAdapter
    {
        if (!isset($config['host'])) {
            throw new BadFlysystemConfigurationException('Host not set for FTP driver');
        }
        if (!isset($config['username'])) {
            throw new BadFlysystemConfigurationException('Username not set for FTP driver');
        }
        if (!isset($config['password']) && !isset($config['privatekey'])) {
            throw new BadFlysystemConfigurationException('Neither password nor private key set for FTP driver');
        }
        return new FTPAdapter([
            'host' => $config['host'],
            'port' => isset($config['port']) ? $config['port'] : 22,
            'username' => $config['username'],
            'password' => $config['password'],
            'privateKey' => isset($config['privatekey']) ? $config['privatekey'] : null,
            'root' => isset($config['root']) ? $config['root'] : null,
            'timeout' => isset($config['timeout']) ? $config['timeout'] : 10,
        ]);
    }
}
