<?php declare(strict_types = 1);

namespace Tests\Unit\Providers;

use Tests\TestCase;

class ShellProviderTest extends TestCase
{
    public function testCreateShell(): void
    {
        $shell = $this->container->get('Psy\Shell');
        $this->assertInstanceOf('Psy\Shell', $shell);
    }
}
