<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Asm89\Twig\CacheExtension\CacheProvider\PsrCacheAdapter;
use Asm89\Twig\CacheExtension\CacheStrategy\LifetimeCacheStrategy;
use Asm89\Twig\CacheExtension\Extension as CacheExtension;
use Statico\Core\Views\Filters\Version;
use Statico\Core\Views\Functions\Form;

final class TwigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Twig\Environment',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Twig\Environment', function () use ($container) {
            $version = $container->get('Statico\Core\Views\Filters\Version');
            $form = $container->get('Statico\Core\Views\Functions\Form');
            $config = [];

            $twig = new Environment($container->get('Twig\Loader\FilesystemLoader'), $config);
            $twig->addFilter(new TwigFilter('version', $version));
            $twig->addFunction(new TwigFunction('form', $form, [
                'is_safe' => ['html']
            ]));
            $cache = $container->get('Psr\Cache\CacheItemPoolInterface');
            $cacheProvider  = new PsrCacheAdapter($cache);
            $cacheStrategy  = new LifetimeCacheStrategy($cacheProvider);
            $cacheExtension = new CacheExtension($cacheStrategy);
            $twig->addExtension($cacheExtension);

            return $twig;
        });
    }
}
