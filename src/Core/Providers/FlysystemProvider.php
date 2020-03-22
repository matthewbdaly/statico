<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\MountManager;

final class FlysystemProvider extends AbstractServiceProvider
{
    protected $provides = ['League\Flysystem\FilesystemInterface'];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('League\Flysystem\FilesystemInterface', function () use ($container) {
                $factory = $container->get('Statico\Core\Factories\FlysystemFactory');
                $config = $container->get('PublishingKit\Config\Config');

                // Decorate the adapter
                $contentFilesystem = $factory->make($config->filesystem->content->toArray());
                $assetFilesystem = $factory->make($config->filesystem->assets->toArray());
                $mediaFilesystem = $factory->make($config->filesystem->media->toArray());
                $cacheFilesystem = $factory->make($config->filesystem->cache->toArray());

                return new MountManager([
                                         'content' => $contentFilesystem,
                                         'assets'  => $assetFilesystem,
                                         'media'   => $mediaFilesystem,
                                         'cache'   => $cacheFilesystem,
                                        ]);
        });
    }
}
