<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class YamlProviderTest extends TestCase
{
    public function testCreateYaml(): void
    {
        $renderer = $this->container->get('Mni\FrontYAML\Parser');
        $this->assertInstanceOf('Mni\FrontYAML\Parser', $renderer);
    }
}
