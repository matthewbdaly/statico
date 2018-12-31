<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class HandlerProviderTest extends TestCase
{
    public function testCreateHandler(): void
    {
        $handler = $this->container->get('Statico\Core\Contracts\Exceptions\Handler');
        $this->assertInstanceOf('Statico\Core\Contracts\Exceptions\Handler', $handler);
        $this->assertInstanceOf('Statico\Core\Exceptions\LogHandler', $handler);
    }
}
