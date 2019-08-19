<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class GlideProviderTest extends TestCase
{
    public function testCreateFlysystem(): void
    {
        $fs = $this->container->get('League\Glide\Server');
        $this->assertInstanceOf('League\Glide\Server', $fs);
    }
}
