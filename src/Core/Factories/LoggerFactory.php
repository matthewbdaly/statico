<?php declare(strict_types=1);

namespace Statico\Core\Factories;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\BrowserConsoleHandler;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\SlackHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\HipChatHandler;
use Zend\Config\Config;
use Statico\Core\Utilities\Str;

final class LoggerFactory
{
    public function make(Config $config): LoggerInterface
    {
        $log = new Logger('app');
        foreach ($config as $configItem) {
            $log->pushHandler($this->createHandler($configItem));
        }
        if (!count($config)) {
            $configItem = new Config([
                'logger' => 'stream',
                'path' => 'logs/site.log',
                'level' => 'warning'
            ]);
            $log->pushHandler($this->createHandler($configItem));
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
            case 'chrome':
                return $this->createChromePHPHandler($config);
            case 'mailer':
                return $this->createNativeMailerHandler($config);
            case 'slack':
                return $this->createSlackHandler($config);
            case 'hipchat':
                return $this->createHipChatHandler($config);
            default:
                return $this->createStreamHandler($config);
        }
    }

    private function createStreamHandler(Config $config): StreamHandler
    {
        $path = Str::make($config->get('path') ? $config->get('path') : 'log/site.logs');
        return new StreamHandler(BASE_DIR . DIRECTORY_SEPARATOR . $path->path()->__toString(), $this->getLevel($config->get('level')));
    }

    private function createFirePHPHandler(Config $config): FirePHPHandler
    {
        return new FirePHPHandler($this->getLevel($config->get('level')));
    }

    private function createBrowserConsoleHandler(Config $config): BrowserConsoleHandler
    {
        return new BrowserConsoleHandler($this->getLevel($config->get('level')));
    }

    private function createChromePHPHandler(Config $config): ChromePHPHandler
    {
        return new ChromePHPHandler($this->getLevel($config->get('level')));
    }

    private function createNativeMailerHandler(Config $config): NativeMailerHandler
    {
        return new NativeMailerHandler(
            $config->get('to'),
            $config->get('subject'),
            $config->get('from'),
            $this->getLevel($config->get('level'))
        );
    }

    private function createSlackHandler(Config $config): SlackHandler
    {
        return new SlackHandler(
            $config->get('token'),
            $config->get('channel'),
            $config->get('username'),
            $config->get('attachment'),
            $config->get('emoji'),
            $this->getLevel($config->get('level'))
        );
    }

    private function createHipChatHandler(Config $config): HipChatHandler
    {
        return new HipChatHandler(
            $config->get('token'),
            $config->get('room'),
            $config->get('name'),
            $config->get('notify'),
            $this->getLevel($config->get('level'))
        );
    }

    private function getLevel(string $level = null): int
    {
        switch ($level) {
            case 'debug':
                return Logger::DEBUG;
            case 'info':
                return Logger::INFO;
            case 'notice':
                return Logger::NOTICE;
            case 'warning':
                return Logger::WARNING;
            case 'error':
                return Logger::ERROR;
            case 'critical':
                return Logger::CRITICAL;
            case 'alert':
                return Logger::ALERT;
            case 'emergency':
                return Logger::EMERGENCY;
            default:
                return Logger::WARNING;
        }
    }
}
