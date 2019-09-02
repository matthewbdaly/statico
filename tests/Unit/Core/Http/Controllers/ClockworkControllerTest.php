<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Http\Controllers\ClockworkController;

final class ClockworkControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        if (defined('E_STRICT')) {
            error_reporting('E_ALL | E_STRICT');
        }
    }

    public function tearDown(): void
    {
        error_reporting(E_ALL);
        parent::tearDown();
    }

    public function testGetResponse()
    {
        $clockwork = m::mock('Clockwork\Support\Vanilla\Clockwork')->makePartial();
        $clockwork->shouldReceive('getMetadata')
            ->with('foo')
            ->once()
            ->andReturn(['bar' => 'baz']);
        $controller = new ClockworkController($clockwork);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $response = $controller->process($request, ['request' => 'foo']);
        $this->assertEquals(json_encode(['bar' => 'baz']), $response->getBody()->getContents());
    }
}
