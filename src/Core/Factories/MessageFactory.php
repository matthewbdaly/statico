<?php declare(strict_types=1);

namespace Statico\Core\Factories;

use Statico\Core\Objects\EmailAddress;
use Statico\Core\Objects\Message;

final class MessageFactory
{
    public static function make(array $data): Message
    {
        $sender = new EmailAddress($data['sender']);
        $recipient = new EmailAddress($data['recipient']);
        $msg = new Message;
        $msg->setSender($sender)
            ->setRecipient($recipient)
            ->setSubject($data['subject'])
            ->setContent($data['content']);
        return $msg;
    }
}
