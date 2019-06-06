<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class RouterProviderTest extends TestCase
{
    public function testCreateFlysystem(): void
    {
        $router = $this->container->get('League\Route\Router');
        $this->assertInstanceOf('League\Route\Router', $router);
    }
}
