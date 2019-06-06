<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class YamlProviderTest extends TestCase
{
    public function testCreateYaml(): void
    {
        $renderer = $this->container->get('Mni\FrontYAML\Parser');
        $this->assertInstanceOf('Mni\FrontYAML\Parser', $renderer);
    }
}
