<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class FlysystemProviderTest extends TestCase
{
    public function testCreateFlysystem(): void
    {
        $fs = $this->container->get('League\Flysystem\MountManager');
        $this->assertInstanceOf('League\Flysystem\MountManager', $fs);
    }
}
