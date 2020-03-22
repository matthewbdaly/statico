<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Clockwork\Support\Vanilla\Clockwork;

final class ClockworkProvider extends AbstractServiceProvider
{
    protected $provides = ['Clockwork\Support\Vanilla\Clockwork'];

    public function register(): void
    {
        // Register items
        $this->getContainer()->share('Clockwork\Support\Vanilla\Clockwork', function () {
            return Clockwork::init();
        });
    }
}
