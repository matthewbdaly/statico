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
        $this->getContainer()
            ->add('League\Flysystem\MountManager', function () {
                $factory = $this->getContainer()->get('Statico\Core\Factories\FlysystemFactory');

                // Decorate the adapter
                $contentFilesystem = $factory->make(['path' => 'content']);
                $assetFilesystem = $factory->make(['path' => 'public/storage/']);
                return new MountManager([
                    'content' => $contentFilesystem,
                    'assets'  => $assetFilesystem,
                ]);
            });
    }
}
