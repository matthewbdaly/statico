<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class ConfigProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $config = $this->container->get('Laminas\Config\Config');
        $this->assertInstanceOf('Laminas\Config\Config', $config);
    }
}
