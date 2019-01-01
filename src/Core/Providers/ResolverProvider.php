<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Paths\LocalResolver;

final class ResolverProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Paths\Resolver',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
             ->add('Statico\Core\Contracts\Paths\Resolver', function () {
                 return new LocalResolver;
             });
    }
}
