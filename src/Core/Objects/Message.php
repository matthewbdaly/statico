<?php declare(strict_types=1);

namespace Statico\Core\Objects;

final class Message
{
    /**
     * @var EmailAddress
     */
    private $sender;

    /**
     * @var EmailAddress
     */
    private $recipient;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $content;

    /**
     * Getter for sender
     *
     * @return EmailAddress
     */
    public function getSender():EmailAddress
    {
        return $this->sender;
    }

    /**
     * Setter for sender
     *
     * @param EmailAddress $sender
     * @return Message
     */
    public function setSender(EmailAddress $sender): Message
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Getter for recipient
     *
     * @return EmailAddress
     */
    public function getRecipient(): EmailAddress
    {
        return $this->recipient;
    }

    /**
     * Setter for recipient
     *
     * @param EmailAddress $recipient
     * @return Message
     */
    public function setRecipient(EmailAddress $recipient): Message
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * Getter for subject
     *
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Setter for subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject(string $subject): Message
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Getter for content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter for content
     *
     * @param string $content
     * @return Message
     */
    public function setContent(string $content): Message
    {
        $this->content = $content;
        return $this;
    }
}
