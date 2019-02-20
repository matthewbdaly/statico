<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Exceptions;

use Tests\TestCase;
use Statico\Core\Exceptions\LogHandler;
use Mockery as m;
use Exception;

class LogHandlerTest extends TestCase
{
    public function testHandleException(): void
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('error');
        $inspector = m::mock('Whoops\Exception\Inspector');
        $run = m::mock('Whoops\RunInterface');
        $handler = new LogHandler($logger);
        $e = new Exception('Test message');
        $handler($e, $inspector, $run);
    }
}
