<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class TwigProviderTest extends TestCase
{
    public function testCreateTwig(): void
    {
        $twig = $this->container->get('Twig\Environment');
        $this->assertInstanceOf('Twig\Environment', $twig);
    }
}
