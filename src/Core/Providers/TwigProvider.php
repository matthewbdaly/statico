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
        $this->getContainer()
             ->add('Twig_Environment', function () {
                 $loader = new \Twig_Loader_Filesystem(BASE_DIR.'/src/views');
                 $twig = new \Twig_Environment($loader, array(
                     'cache' => BASE_DIR.'/cache/views',
                 ));
                 return $twig;
             });
    }
}
