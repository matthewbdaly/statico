<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Asm89\Twig\CacheExtension\CacheProvider\PsrCacheAdapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Statico\Core\Views\Filters\Mix;
use Statico\Core\Views\Filters\Version;
use Statico\Core\Views\Functions\Form;

final class TwigProvider extends AbstractServiceProvider
{
    protected $provides = [
                           'Twig\Environment',
                           'Statico\Core\Contracts\Services\Navigator',
                          ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Statico\Core\Contracts\Services\Navigator', function () use ($container) {
            return $container->get('Statico\Core\Services\Navigation\DynamicNavigator');
        });
        $container->add('Twig\Environment', function () use ($container) {
            $version = $container->get('Statico\Core\Views\Filters\Version');
            $mix = $container->get('Statico\Core\Views\Filters\Mix');
            $config = [];
            if (getenv('APP_ENV') !== 'development') {
                $config['cache'] = BASE_DIR . '/cache/views';
            }

            $twig = new Environment($container->get('Twig\Loader\FilesystemLoader'), $config);
            $twig->addFilter(new TwigFilter('version', $version));
            $twig->addFilter(new TwigFilter('mix', $mix));
            $twig->addFunction(new TwigFunction(
                'form',
                $container->get('Statico\Core\Views\Functions\Form')
            ));
            $cache = $container->get('Psr\Cache\CacheItemPoolInterface');
            $cacheProvider  = new PsrCacheAdapter($cache);
            $cacheStrategy  = new LifetimeCacheStrategy($cacheProvider);
            $cacheExtension = new CacheExtension($cacheStrategy);
            $twig->addExtension($cacheExtension);
            $twig->addGlobal('navigation', $container->get('Statico\Core\Contracts\Services\Navigator')->__invoke());

            return $twig;
        });
    }
}
