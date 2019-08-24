<?php declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\SendmailTransport;

final class MailerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Symfony\Component\Mailer\MailerInterface',
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add('Symfony\Component\Mailer\MailerInterface', function() {
                $transport = new SendmailTransport();
                return new Mailer($transport);
            });
    }
}
