<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FlysystemFactory;
use Mockery as m;

final class FlysystemFactoryTest extends TestCase
{
    public function testLocal()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'local',
            'path' => 'content/'
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\Adapter\Local', $cache->getAdapter());
    }

    public function testLocalByDefault()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'path' => 'content/'
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\Adapter\Local', $cache->getAdapter());
    }

    public function testLocalMisconfigured()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
        ]);
    }

    public function testDropbox()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'dropbox',
            'token' => 'foo'
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('Spatie\FlysystemDropbox\DropboxAdapter', $cache->getAdapter());
    }

    public function testDropboxMisconfigured()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'dropbox',
        ]);
    }

    public function testAzure()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'azure',
            'container' => 'foo',
            'name' => 'bar',
            'key' => 'baz',
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter', $cache->getAdapter());
    }

    public function testAzureMisconfiguredContainer()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'azure',
            'name' => 'bar',
            'key' => 'baz',
        ]);
    }

    public function testAzureMisconfiguredName()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'azure',
            'container' => 'foo',
            'key' => 'baz',
        ]);
    }

    public function testAzureMisconfiguredKey()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'azure',
            'container' => 'foo',
            'name' => 'bar',
        ]);
    }

    public function testS3()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
            'bucket' => 'foo',
            'key' => 'bar',
            'secret' => 'baz',
            'region' => 'foo',
            'version' => 'latest',
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\AwsS3v3\AwsS3Adapter', $cache->getAdapter());
    }

    public function testS3MisconfiguredKey()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
            'secret' => 'baz',
            'region' => 'foo',
            'version' => 'latest',
        ]);
    }

    public function testS3MisconfiguredSecret()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
            'key' => 'bar',
            'region' => 'foo',
            'version' => 'latest',
        ]);
    }

    public function testS3MisconfiguredRegion()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
            'key' => 'bar',
            'secret' => 'baz',
            'version' => 'latest',
        ]);
    }

    public function testS3MisconfiguredVersion()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
            'key' => 'bar',
            'secret' => 'baz',
            'region' => 'foo',
        ]);
    }

    public function testSFTP()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'sftp',
            'host' => 'foo.com',
            'username' => 'bob',
            'password' => 'password',
            'root' => 'foo',
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\Sftp\SftpAdapter', $cache->getAdapter());
    }

    public function testSFTPMisconfiguredHost()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'sftp',
            'username' => 'bob',
            'password' => 'password',
            'root' => 'foo',
        ]);
    }

    public function testSFTPMisconfiguredUsername()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'sftp',
            'host' => 'foo.com',
            'password' => 'password',
            'root' => 'foo',
        ]);
    }

    public function testSFTPMisconfiguredPassword()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'sftp',
            'host' => 'foo.com',
            'username' => 'bob',
            'root' => 'foo',
        ]);
    }

    public function testFTP()
    {
        $pool = m::mock('Stash\Pool');
        $pool->shouldReceive('getItem')->once()->andReturn($pool);
        $pool->shouldReceive('get')->once()->andReturn(false);
        $pool->shouldReceive('isMiss')->once()->andReturn(true);
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'ftp',
            'host' => 'foo.com',
            'username' => 'bob',
            'password' => 'password',
            'root' => 'foo',
        ]);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $fs);
        $cache = $fs->getAdapter();
        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $cache);
        $this->assertInstanceOf('League\Flysystem\Adapter\Ftp', $cache->getAdapter());
    }

    public function testFTPMisconfiguredHost()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'ftp',
            'username' => 'bob',
            'password' => 'password',
            'root' => 'foo',
        ]);
    }

    public function testFTPMisconfiguredUsername()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'ftp',
            'host' => 'foo.com',
            'password' => 'password',
            'root' => 'foo',
        ]);
    }

    public function testFTPMisconfiguredPassword()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'ftp',
            'host' => 'foo.com',
            'username' => 'bob',
            'root' => 'foo',
        ]);
    }
}
