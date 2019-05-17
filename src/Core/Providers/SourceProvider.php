<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Sources\MarkdownFiles;

final class SourceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Sources\Source',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Statico\Core\Contracts\Sources\Source', $container->get(MarkdownFiles::class));
    }
}
