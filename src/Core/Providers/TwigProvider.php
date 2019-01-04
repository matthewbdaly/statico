<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

final class TwigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Twig_Environment',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Twig_Loader_Filesystem', function () {
            return new \Twig_Loader_Filesystem(BASE_DIR.'/src/views');
        });
        $container->add('Twig_Environment', function () {
            $twig = new \Twig_Environment($this->getContainer()->get('Twig_Loader_Filesystem'), array(
                'cache' => BASE_DIR.'/cache/views',
            ));
            return $twig;
        });
    }
}
