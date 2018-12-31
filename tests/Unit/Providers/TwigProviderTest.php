<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class TwigProviderTest extends TestCase
{
    public function testCreateTwig(): void
    {
        $twig = $this->container->get('Twig_Environment');
        $this->assertInstanceOf('Twig_Environment', $twig);
    }
}
