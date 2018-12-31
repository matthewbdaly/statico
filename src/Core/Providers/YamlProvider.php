<?php declare(strict_types = 1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Mni\FrontYAML\Parser;

class YamlProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Mni\FrontYAML\Parser',
    ];

    public function register(): void
    {
        // Register items
        $this->getContainer()
            ->share('Mni\FrontYAML\Parser', function () {
                return new Parser;
            });
    }
}
