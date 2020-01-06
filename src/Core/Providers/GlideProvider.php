<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Glide\ServerFactory;
use League\Glide\Responses\PsrResponseFactory;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Stream;

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
                'response' => new PsrResponseFactory(new Response(), function ($stream) {
                    return new Stream($stream);
                }),
            ]);
        });
    }
}
