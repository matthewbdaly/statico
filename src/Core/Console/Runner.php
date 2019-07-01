<?php declare(strict_types=1);

namespace Statico\Core\Console;

use Statico\Core\Application;

final class Runner
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct()
    {
        $this->app = new Application;
    }

    public function __invoke()
    {
        $this->app->bootstrap();
        $container = $this->app->getContainer();
        $console = $container->get('Symfony\Component\Console\Application');
        $console->add($container->get('Statico\Core\Console\FlushCache'));
        $console->add($container->get('Statico\Core\Console\Shell'));
        $console->add($container->get('Statico\Core\Console\Server'));
        $console->add($container->get('Statico\Core\Console\GenerateIndex'));
        $console->add($container->get('Statico\Core\Console\GenerateSitemap'));
        $console->run();
    }
}
