<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\TwigFilter;
use Statico\Core\Views\Helpers\Version;

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
            $config = [];
            if (getenv('APP_ENV') !== 'development') {
                $config['cache'] = BASE_DIR.'/cache/views';
            }

            $twig = new Environment($container->get('Twig\Loader\FilesystemLoader'), $config);
            $filter = new TwigFilter('version', new Version);
            $twig->addFilter($filter);
            return $twig;
        });
    }
}
