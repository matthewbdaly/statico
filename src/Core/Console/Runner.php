<?php declare(strict_types=1);

namespace Statico\Core\Console;

use Statico\Core\Kernel\Application;
use Dotenv\Dotenv;
use Exception;

final class Runner
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct()
    {
        $this->app = new Application();
    }

    public function __invoke()
    {
        try {
            if (file_exists(BASE_DIR . DIRECTORY_SEPARATOR . '.env')) {
                $dotenv = new Dotenv(BASE_DIR);
                $dotenv->load();
            }
            $this->app->bootstrap();
            $container = $this->app->getContainer();
            $console = $container->get('Symfony\Component\Console\Application');
            $console->add($container->get('Statico\Core\Console\Commands\FlushCache'));
            $console->add($container->get('Statico\Core\Console\Commands\Shell'));
            $console->add($container->get('Statico\Core\Console\Commands\Server'));
            $console->add($container->get('Statico\Core\Console\Commands\GenerateIndex'));
            $console->add($container->get('Statico\Core\Console\Commands\GenerateSitemap'));
            $console->run();
        } catch (Exception $err) {
            $this->returnError($err);
        }
    }

    private function returnError(Exception $err): void
    {
        $msg = "Unable to run - " . $err->getMessage();
        $msg .= "\n" . $err->__toString();
        $msg .= "\n";
        echo $msg;
    }
}
