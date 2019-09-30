<?php

declare(strict_types=1);

namespace Statico\Core\Objects;

use Statico\Core\Exceptions\Objects\EmailAddressInvalid;

final class EmailAddress
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            throw new EmailAddressInvalid('The provided email address is not valid');
        }
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function equals(EmailAddress $email): bool
    {
        return ($this->email === $email->__toString());
    }
}
