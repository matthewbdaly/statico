<?php declare(strict_types=1);

namespace Statico\Core\Console;

use Symfony\Component\Console\Application;

final class Runner
{
    public function __invoke()
    {
        $console = new Application;
        $app = new \Statico\Core\Application;
        $app->bootstrap();
        $container = $app->getContainer();
        $console->add($container->get('Statico\Core\Console\FlushCache'));
        $console->add($container->get('Statico\Core\Console\Shell'));
        $console->add($container->get('Statico\Core\Console\Server'));
        $console->add($container->get('Statico\Core\Console\GenerateIndex'));
        $console->add($container->get('Statico\Core\Console\GenerateSitemap'));
        $console->run();
    }
}
