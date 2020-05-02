<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class ClockworkProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $clockwork = $this->container->get('Clockwork\Support\Vanilla\Clockwork');
        $this->assertInstanceOf('Clockwork\Support\Vanilla\Clockwork', $clockwork);
    }
}
