<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Event\Emitter;

final class EventProvider extends AbstractServiceProvider
{
    protected $provides = [
        'League\Event\EmitterInterface',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->share('League\Event\EmitterInterface', function () use ($container) {
                $emitter = $container->get('League\Event\Emitter');
                return $emitter;
        });
    }
}
