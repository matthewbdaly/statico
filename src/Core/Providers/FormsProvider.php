<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

final class FormsProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Factories\FormFactory',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()->add(
            'Statico\Core\Contracts\Factories\FormFactory',
            'Statico\Core\Factories\Forms\LaminasFormFactory'
        );
    }
}
