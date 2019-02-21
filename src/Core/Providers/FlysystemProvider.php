<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Memory as MemoryStore;

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

                // Create the cache store
                $cacheStore = new MemoryStore();

                // Decorate the adapter
                $contentFilesystem = new Filesystem(
                    new CachedAdapter(
                        new Local(BASE_DIR.'/content/'),
                        $cacheStore
                    )
                );
                $assetFilesystem = new Filesystem(
                    new CachedAdapter(
                        new Local(BASE_DIR.'/public/storage/'),
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
