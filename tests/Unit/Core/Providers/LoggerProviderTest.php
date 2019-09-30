<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Providers;

use Tests\TestCase;

final class LoggerProviderTest extends TestCase
{
    public function testCreateLogger(): void
    {
        $logger = $this->container->get('Psr\Log\LoggerInterface');
        $this->assertInstanceOf('Psr\Log\LoggerInterface', $logger);
        $this->assertInstanceOf('Monolog\Logger', $logger);
    }
}
