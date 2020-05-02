<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class ShellProviderTest extends TestCase
{
    public function testCreateShell(): void
    {
        $shell = $this->container->get('Psy\Shell');
        $this->assertInstanceOf('Psy\Shell', $shell);
    }
}
