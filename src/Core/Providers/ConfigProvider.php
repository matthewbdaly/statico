<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PublishingKit\Config\Config;

final class ConfigProvider extends AbstractServiceProvider
{
    protected $provides = ['PublishingKit\Config\Config'];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('PublishingKit\Config\Config', function () {
                return Config::fromFiles(glob(ROOT_DIR . 'config/*.*'));
            });
    }
}
