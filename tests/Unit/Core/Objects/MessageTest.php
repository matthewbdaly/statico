<?php declare(strict_types=1);

namespace Tests\Unit\Core\Objects;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Objects\Message;
use Statico\Core\Objects\EmailAddress;

class MessageTest extends TestCase
{
    public function testCreate()
    {
        $sender = new EmailAddress('bob@example.com');
        $recipient = new EmailAddress('eric@example.com');
        $msg = new Message;
        $msg->setSender($sender);
        $msg->setRecipient($recipient);
        $msg->setSubject('Test');
        $msg->setContent('Just testing');
        $this->assertTrue($msg->getSender()->equals($sender));
        $this->assertTrue($msg->getRecipient()->equals($recipient));
        $this->assertEquals('Test', $msg->getSubject());
        $this->assertEquals('Just testing', $msg->getContent());
    }
}
