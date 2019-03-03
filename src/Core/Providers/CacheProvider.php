<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Stash\Pool;
use Stash\Driver\FileSystem;

final class CacheProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Psr\Cache\CacheItemPoolInterface',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Stash\Pool', function () {
                 $driver = new FileSystem;
                 $pool = new Pool($driver);
                 return $pool;
        });
        $container->add('Psr\Cache\CacheItemPoolInterface', 'Stash\Pool');
    }
}
