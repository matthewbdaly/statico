<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class ResolverProviderTest extends TestCase
{
    public function testCreateResolver(): void
    {
        $logger = $this->container->get('Statico\Core\Contracts\Paths\Resolver');
        $this->assertInstanceOf('Statico\Core\Contracts\Paths\Resolver', $logger);
        $this->assertInstanceOf('Statico\Core\Paths\LocalResolver', $logger);
    }
}
