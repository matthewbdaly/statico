<?php declare(strict_types=1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\MessageFactory;
use Mockery as m;

class MessageFactoryTest extends TestCase
{
    public function testMake()
    {
        $msg = MessageFactory::make([
            'sender' => 'bob@example.com',
            'recipient' => 'eric@example.com',
            'subject' => 'Test',
            'content' => 'Just testing'
        ]);
        $this->assertEquals('Test', $msg->getSubject());
        $this->assertEquals('Just testing', $msg->getContent());
        $this->assertEquals('bob@example.com', $msg->getSender()->__toString());
        $this->assertEquals('eric@example.com', $msg->getRecipient()->__toString());
    }
}
