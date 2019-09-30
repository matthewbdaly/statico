<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class ContainerProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $container = $this->container->get('Psr\Container\ContainerInterface');
        $this->assertInstanceOf('Psr\Container\ContainerInterface', $container);
        $this->assertInstanceOf('League\Container\Container', $container);
    }
}
