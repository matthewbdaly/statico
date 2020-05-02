<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Providers;

use Statico\Tests\TestCase;

final class MailerProviderTest extends TestCase
{
    public function testCreateSession(): void
    {
        $mailer = $this->container->get('Symfony\Component\Mailer\MailerInterface');
        $this->assertInstanceOf('Symfony\Component\Mailer\MailerInterface', $mailer);
        $this->assertInstanceOf('Symfony\Component\Mailer\Mailer', $mailer);
    }
}
