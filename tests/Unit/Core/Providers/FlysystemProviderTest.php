<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class FlysystemProviderTest extends TestCase
{
    public function testCreateFlysystem(): void
    {
        $fs = $this->container->get('League\Flysystem\MountManager');
        $this->assertInstanceOf('League\Flysystem\MountManager', $fs);
    }
}
