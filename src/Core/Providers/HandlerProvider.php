<?php declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Exceptions\LogHandler;

final class HandlerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Exceptions\Handler',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->add('Statico\Core\Contracts\Exceptions\Handler', function() {
                return new LogHandler($this->getContainer()->get('Psr\Log\LoggerInterface'));
            });
    }
}
