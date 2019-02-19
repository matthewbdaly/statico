<?php declare(strict_types = 1);

namespace Statico\Plugins\Sitemap;

use Statico\Core\Contracts\Extension\Plugin;

final class Main implements Plugin
{
    public function register(): void
    {
        // Register plugin
    }

    public function getViews(): array
    {
        return [];
    }
}
