<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class ViewProviderTest extends TestCase
{
    public function testCreateTwig(): void
    {
        $renderer = $this->container->get('Statico\Core\Contracts\Views\Renderer');
        $this->assertInstanceOf('Statico\Core\Contracts\Views\Renderer', $renderer);
        $this->assertInstanceOf('Statico\Core\Views\TwigRenderer', $renderer);
    }
}
