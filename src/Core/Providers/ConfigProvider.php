<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

final class ConfigProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Zend\Config\Reader\ReaderInterface',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('Zend\Config\Reader\ReaderInterface', function () {
                $parser = $this->getContainer()->get('Statico\Core\Utilities\YamlWrapper');
                return new \Zend\Config\Reader\Yaml($parser);
            });
    }
}
