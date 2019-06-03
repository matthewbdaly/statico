<?php declare(strict_types=1);

namespace Statico\Core\Csrf;

final class Token
{
    /**
     * @var string
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public static function generate(): Token
    {
        $token = bin2hex(random_bytes(256));
        return new Token($token);
    }

    public function toString(): string
    {
        return $this->token;
    }

    public function equals(Token $token): bool
    {
        return ($this->token === $token->toString());
    }
}
