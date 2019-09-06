<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class SourceProviderTest extends TestCase
{
    public function testCreateSouce(): void
    {
        $source = $this->container->get('Statico\Core\Contracts\Sources\Source');
        $this->assertInstanceOf('Statico\Core\Contracts\Sources\Source', $source);
        $this->assertInstanceOf('Statico\Core\Sources\MarkdownFiles', $source);
    }
}
