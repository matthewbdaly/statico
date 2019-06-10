<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Factories\LoggerFactory;

final class LoggerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Psr\Log\LoggerInterface',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
             ->add('Psr\Log\LoggerInterface', function () {
                 $factory = new LoggerFactory;
                 return $factory->make([]);
             });
    }
}
