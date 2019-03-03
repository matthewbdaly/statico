<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Stash as StashStore;
use Statico\Core\Factories\FlysystemFactory;

final class FlysystemProvider extends AbstractServiceProvider
{
    protected $provides = [
        'League\Flysystem\MountManager',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->add('League\Flysystem\MountManager', function () {
                $pool = $this->getContainer()->get('Psr\Cache\CacheItemPoolInterface');

                // Create the cache store
                $cacheStore = new StashStore($pool, 'pages', 300);

                // Decorate the adapter
                $contentFilesystem = new Filesystem(
                    new CachedAdapter(
                        FlysystemFactory::create(['path' => 'content']),
                        $cacheStore
                    )
                );
                $assetFilesystem = new Filesystem(
                    new CachedAdapter(
                        FlysystemFactory::create(['path' => 'public/storage/']),
                        $cacheStore
                    )
                );
                return new MountManager([
                    'content' => $contentFilesystem,
                    'assets'  => $assetFilesystem,
                ]);
            });
    }
}
