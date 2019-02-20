<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class SourceProviderTest extends TestCase
{
    public function testCreateSouce(): void
    {
        $source = $this->container->get('Statico\Core\Contracts\Sources\Source');
        $this->assertInstanceOf('Statico\Core\Contracts\Sources\Source', $source);
        $this->assertInstanceOf('Statico\Core\Sources\MarkdownFiles', $source);
    }
}
