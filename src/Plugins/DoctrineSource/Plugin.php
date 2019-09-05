<?php declare(strict_types=1);

namespace Statico\Plugins\DoctrineSource;

use Statico\Core\Contracts\Plugin as PluginContract;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

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
        $this->registerConsoleCommands();
    }

    private function registerServiceProvider(): void
    {
        $this->container->addServiceProvider('Statico\Plugins\DoctrineSource\Providers\DoctrineProvider');
    }

    private function registerConsoleCommands(): void
    {
        $helperSet = ConsoleRunner::createHelperSet($this->container->get('Doctrine\ORM\EntityManager'));
        $this->console->setHelperSet($helperSet);
        ConsoleRunner::addCommands($this->console);
    }
}
