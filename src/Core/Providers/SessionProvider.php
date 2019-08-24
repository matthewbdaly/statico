<?php declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Symfony\Component\HttpFoundation\Session\SessionInterface',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
                ->add('Symfony\Component\HttpFoundation\Session\SessionInterface', function () {
                    return new Session();
                });
    }
}
