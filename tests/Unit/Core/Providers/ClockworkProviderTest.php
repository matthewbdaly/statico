<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class ClockworkProvidern extends TestCase
{
    public function testCreateContainer(): void
    {
        $clockwork = $this->container->get('Clockwork\Support\Vanilla\Clockwork');
        $this->assertInstanceOf('Clockwork\Support\Vanilla\Clockwork', $clockwork);
    }
}
