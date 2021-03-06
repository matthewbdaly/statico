<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Factories;

use Statico\Tests\TestCase;
use Statico\Core\Factories\MonologFactory;
use Mockery as m;
use PublishingKit\Config\Config;

final class LoggerFactoryTest extends TestCase
{
    /**
     * @dataProvider levelProvider
     */
    public function testCreateStreamHandler($level)
    {
        $factory = new MonologFactory();
        $config = new Config([
                              [
                               'logger' => 'stream',
                               'path'   => './logs/site.log',
                               'level'  => $level,
                              ],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handlers[0]);
    }

    public function testCreateDefaultHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handlers[0]);
    }

    public function testCreateFirePHPHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([
                              ['logger' => 'firephp'],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\FirePHPHandler', $handlers[0]);
    }

    public function testCreateBrowserConsoleHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([
                              ['logger' => 'browser-console'],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\BrowserConsoleHandler', $handlers[0]);
    }

    public function testCreateChromePHPHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([
                              ['logger' => 'chrome'],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\ChromePHPHandler', $handlers[0]);
    }

    public function testCreateNativeMailerHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([
                              [
                               'logger'  => 'mailer',
                               'from'    => 'bob@example.com',
                               'to'      => 'eric@example.com',
                               'subject' => 'Error',
                              ],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\NativeMailerHandler', $handlers[0]);
    }

    public function testCreateSlackHandler()
    {
        $factory = new MonologFactory();
        $config = new Config([
                              [
                               'logger'     => 'slack',
                               'token'      => 'foo',
                               'channel'    => 'bar',
                               'username'   => 'baz',
                               'attachment' => true,
                               'emoji'      => 'poo',
                              ],
                             ]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\SlackHandler', $handlers[0]);
    }

    public function levelProvider()
    {
        return [
                ['debug'],
                ['info'],
                ['notice'],
                ['warning'],
                ['error'],
                ['critical'],
                ['alert'],
                ['emergency'],
               ];
    }
}
