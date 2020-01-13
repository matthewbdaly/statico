<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class ConfigProviderTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $config = $this->container->get('PublishingKit\Config\Config');
        $this->assertInstanceOf('PublishingKit\Config\Config', $config);
    }
}
