<?php

declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Laminas\Config\Reader\Yaml;
use Laminas\Config\Config;
use Laminas\Config\Factory;

final class ConfigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Laminas\Config\Config',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('Laminas\Config\Config', function () {
                $parser = $this->getContainer()->get('Statico\Core\Utilities\YamlWrapper');
                Factory::registerReader('yml', new Yaml($parser));
                return new Config(Factory::fromFiles(glob(BASE_DIR . 'config/*.*')));
            });
    }
}
