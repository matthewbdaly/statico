<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\LoggerFactory;
use Mockery as m;
use Zend\Config\Config;

final class LoggerFactoryTest extends TestCase
{
    public function testCreateStreamHandler()
    {
        $factory = new LoggerFactory;
        $config = new Config([[
            'logger' => 'stream',
            'path' => './logs/site.log'
        ]]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handlers[0]);
    }

    public function testCreateDefaultHandler()
    {
        $factory = new LoggerFactory;
        $config = new Config([]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handlers[0]);
    }

    public function testCreateFirePHPHandler()
    {
        $factory = new LoggerFactory;
        $config = new Config([[
            'logger' => 'firephp',
        ]]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\FirePHPHandler', $handlers[0]);
    }

    public function testCreateBrowserConsoleHandler()
    {
        $factory = new LoggerFactory;
        $config = new Config([[
            'logger' => 'browser-console',
        ]]);
        $logger = $factory->make($config);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\BrowserConsoleHandler', $handlers[0]);
    }
}
