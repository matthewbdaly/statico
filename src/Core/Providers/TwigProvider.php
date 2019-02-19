<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;

final class TwigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Twig\Environment',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Twig\Environment', function () {
            $twig = new Environment($this->getContainer()->get('Twig\Loader\FilesystemLoader'), array(
                'cache' => BASE_DIR.'/cache/views',
            ));
            return $twig;
        });
    }
}
