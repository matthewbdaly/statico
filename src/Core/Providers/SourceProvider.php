<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

final class SourceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Sources\Source',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $config = $container->get('Zend\Config\Config');
        $container->add('Statico\Core\Contracts\Sources\Source', $container->get($config->get('source')));
    }
}
