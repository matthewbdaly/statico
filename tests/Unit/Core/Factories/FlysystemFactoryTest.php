<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FlysystemFactory;
use Mockery as m;

class FlysystemFactoryTest extends TestCase
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

    public function testAzureMisconfigured()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'azure',
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

    public function testS3Misconfigured()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 's3',
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

    public function testSFTPMisconfigured()
    {
        $this->expectException('Statico\Core\Exceptions\Factories\BadFlysystemConfigurationException');
        $pool = m::mock('Stash\Pool');
        $factory = new FlysystemFactory($pool);
        $fs = $factory->make([
            'driver' => 'sftp',
        ]);
    }
}
