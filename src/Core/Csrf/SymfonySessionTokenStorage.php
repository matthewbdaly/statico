<?php

declare(strict_types=1);

namespace Statico\Core\Csrf;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SymfonySessionTokenStorage implements TokenStorage
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function store(string $key, Token $token): void
    {
        $this->session->set($key, $token->__toString());
    }

    public function retrieve(string $key): ?Token
    {
        $tokenValue = $this->session->get($key);

        if ($tokenValue === null) {
            return null;
        }

        return new Token($tokenValue);
    }
}
