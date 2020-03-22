<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Loader\FilesystemLoader;

final class TwigLoaderProvider extends AbstractServiceProvider
{
    protected $provides = ['Twig\Loader\FilesystemLoader'];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Twig\Loader\FilesystemLoader', function () {
            return new FilesystemLoader(BASE_DIR . 'views');
        });
    }
}
