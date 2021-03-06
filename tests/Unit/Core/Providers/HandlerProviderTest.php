<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class HandlerProviderTest extends TestCase
{
    public function testCreateHandler(): void
    {
        $handler = $this->container->get('Statico\Core\Contracts\Exceptions\Handler');
        $this->assertInstanceOf('Statico\Core\Contracts\Exceptions\Handler', $handler);
        $this->assertInstanceOf('Statico\Core\Exceptions\LogHandler', $handler);
    }
}
