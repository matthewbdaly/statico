<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
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
            if (getenv('APP_ENV') !== 'development') {
                $config['cache'] = BASE_DIR.'/cache/views';
            }

            $twig = new Environment($container->get('Twig\Loader\FilesystemLoader'), $config);
            $twig->addFilter(new TwigFilter('version', $version));
            $twig->addFunction(new TwigFunction('form', $form, [
                'is_safe' => ['html']
            ]));
            return $twig;
        });
    }
}
