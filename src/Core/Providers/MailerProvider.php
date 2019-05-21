<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

final class MailerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Zend\Mail\Transport\TransportInterface',
    ];

    public function register(): void
    {
        $this->getContainer()
            ->add('Zend\Mail\Transport\TransportInterface', function () {
                $transport = new Smtp();
                $options   = new SmtpOptions([
                    'name'              => getenv('SMTP_NAME'),
                    'host'              => getenv('SMTP_HOST'),
                    'port'              => getenv('SMTP_PORT'),
                    'connection_class'  => getenv('SMTP_CONNECTION_CLASS'),
                    'connection_config' => array(
                        'username' => getenv('SMTP_USERNAME'),
                        'password' => getenv('SMTP_PASS'),
                    ),
                ]);
                $transport->setOptions($options);
                return $transport;
            });
    }
}
