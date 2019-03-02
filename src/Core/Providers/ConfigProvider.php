<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Config\Reader\Yaml;
use Zend\Config\Config;
use Zend\Config\Factory;

final class ConfigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Zend\Config\Config',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('Zend\Config\Config', function () {
                $parser = $this->getContainer()->get('Statico\Core\Utilities\YamlWrapper');
                Factory::registerReader('yml', new Yaml($parser));
                return new Config(Factory::fromFile('config.yml'));
            });
    }
}
