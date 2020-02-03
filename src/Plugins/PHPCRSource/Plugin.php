<?php

declare(strict_types=1);

namespace Statico\Plugins\PHPCRSource;

use Statico\Core\Contracts\Plugin as PluginContract;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

final class Plugin implements PluginContract
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Application
     */
    private $console;

    public function __construct(ContainerInterface $container, Application $console)
    {
        $this->container = $container;
        $this->console = $console;
    }

    public function register(): void
    {
        $this->registerServiceProvider();
    }

    private function registerServiceProvider(): void
    {
        $this->container->addServiceProvider('Statico\Plugins\PHPCRSource\Providers\DocumentManagerProvider');
        $this->container->addServiceProvider('Statico\Plugins\PHPCRSource\Providers\PHPCRRepositoryProvider');
    }
}
