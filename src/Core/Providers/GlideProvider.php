<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\ServerFactory;

final class GlideProvider extends AbstractServiceProvider
{
    protected $provides = [
        'League\Glide\Server'
    ];

    public function register(): void
    {
        $container = $this->getContainer();
        $container->share('League\Glide\Server', function () use ($container) {
            $fs = $container->get('League\Flysystem\FilesystemInterface');
            $source = $fs->getFilesystem('media');
            $cache = $fs->getFilesystem('cache');
            return ServerFactory::create([
                'source' => $source,
                'cache' => $cache,
            ]);
        });
    }
}
