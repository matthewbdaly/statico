<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Paths\LocalResolver;
use Statico\Core\Paths\LocalPath;

final class ResolverProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Paths\Path',
        'Statico\Core\Contracts\Paths\Resolver',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Statico\Core\Contracts\Paths\Path', function () {
            return new LocalPath(BASE_DIR.CONTENT_PATH);
        });
        $container->add('Statico\Core\Contracts\Paths\Resolver', function () {
            $path = $this->getContainer()->get('Statico\Core\Contracts\Paths\Path');
            return new LocalResolver($path);
        });
    }
}
