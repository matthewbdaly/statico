<?php

declare(strict_types=1);

namespace Statico\Core\Contracts\Extension;

/**
 * Interface for plugins
 */
interface Plugin
{
    public function register(): void;

    public function getViews(): array;
}
