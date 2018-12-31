<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class RouterProviderTest extends TestCase
{
    public function testCreateFlysystem(): void
    {
        $router = $this->container->get('League\Route\Router');
        $this->assertInstanceOf('League\Route\Router', $router);
    }
}
