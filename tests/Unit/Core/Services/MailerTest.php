<?php declare(strict_types=1);

namespace Tests\Unit\Core\Services;

use Tests\TestCase;
use Statico\Core\Services\Mailer;
use Statico\Core\Factories\MessageFactory;

class MailerTest extends TestCase
{
    public function testSend()
    {
        $mailer = new Mailer;
        $msg = MessageFactory::make([
            'sender' => 'bob@example.com',
            'recipient' => 'eric@example.com',
            'subject' => 'Test',
            'content' => 'Just testing'
        ]);
    }
}
