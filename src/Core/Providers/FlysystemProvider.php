<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Flysystem\MountManager;

final class FlysystemProvider extends AbstractServiceProvider
{
    protected $provides = [
        'League\Flysystem\MountManager',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('League\Flysystem\MountManager', function () use ($container) {
                $factory = $container->get('Statico\Core\Factories\FlysystemFactory');
                $config = $container->get('Zend\Config\Config');

                // Decorate the adapter
                $contentFilesystem = $factory->make($config->filesystem->content->toArray());
                $assetFilesystem = $factory->make($config->filesystem->assets->toArray());

                return new MountManager([
                    'content' => $contentFilesystem,
                    'assets'  => $assetFilesystem,
                ]);
        });
    }
}
