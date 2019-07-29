<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\LoggerFactory;
use Mockery as m;

final class LoggerFactoryTest extends TestCase
{
    public function testCreateStreamHandler()
    {
        $factory = new LoggerFactory;
        $logger = $factory->make([]);
        $this->assertInstanceOf('Monolog\Logger', $logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf('Monolog\Handler\StreamHandler', $handlers[0]);
    }
}
