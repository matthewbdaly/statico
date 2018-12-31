<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Views\TwigRenderer;

final class ViewProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Views\Renderer',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
             ->add('Statico\Core\Contracts\Views\Renderer', function () {
                 $twig = $this->getContainer()->get('Twig_Environment');
                 return new TwigRenderer($twig);
             });
    }
}
