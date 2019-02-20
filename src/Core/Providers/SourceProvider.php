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
        $this->getContainer()
            ->add('Statico\Core\Contracts\Sources\Source', MarkdownFiles::class)
            ->addArgument('League\Flysystem\MountManager')
            ->addArgument('Mni\FrontYAML\Parser');
    }
}
