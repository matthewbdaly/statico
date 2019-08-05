<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Zend\Config\Config;

final class LoggerFactory
{
    public function make(Config $config): LoggerInterface
    {
        $log = new Logger('app');
        foreach ($config as $configItem) {
            $log->pushHandler($this->createHandler($configItem));
        }
        if (!count($config)) {
            $log->pushHandler(new StreamHandler('./logs/site.log', Logger::WARNING));
        }
        return $log;
    }

    private function createHandler(Config $config): HandlerInterface
    {
        switch ($config->get('logger')) {
            case 'browser-console':
                return $this->createBrowserConsoleHandler($config);
            case 'firephp':
                return $this->createFirePHPHandler($config);
            case 'stream':
                return $this->createStreamHandler($config);
        }
    }

    private function createStreamHandler(Config $config): StreamHandler
    {
        return new StreamHandler($config->get('path') ? $config->get('path') : './log/site.logs');
    }

    private function createFirePHPHandler(Config $config): FirePHPHandler
    {
        return new FirePHPHandler();
    }

    private function createBrowserConsoleHandler(Config $config): BrowserConsoleHandler
    {
        return new BrowserConsoleHandler();
    }
}
