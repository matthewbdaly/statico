<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class EventProviderTest extends TestCase
{
    public function testCreateEventEmitter(): void
    {
        $emitter = $this->container->get('League\Event\EmitterInterface');
        $this->assertInstanceOf('League\Event\EmitterInterface', $emitter);
        $this->assertInstanceOf('League\Event\Emitter', $emitter);
    }
}
