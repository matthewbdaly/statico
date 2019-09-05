<?php declare(strict_types=1);

namespace Statico\Plugins\DoctrineSource;

use Statico\Core\Contracts\Plugin as PluginContract;
use Psr\Container\ContainerInterface;

final class Plugin implements PluginContract
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function register(): void
    {
        $this->registerServiceProvider();
    }

    private function registerServiceProvider(): void
    {
        $this->container->addServiceProvider('Statico\Plugins\DoctrineSource\Providers\DoctrineProvider');
    }
}
