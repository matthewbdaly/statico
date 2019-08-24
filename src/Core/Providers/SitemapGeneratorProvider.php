<?php declare(strict_types=1);

namespace Statico\Core\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Statico\Core\Generators\XmlStringSitemap;

final class SitemapGeneratorProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Statico\Core\Contracts\Generators\Sitemap',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Statico\Core\Contracts\Generators\Sitemap', function() use ($container) {
            $config = $container->get('Zend\Config\Config');
            $source = $container->get('Statico\Core\Contracts\Sources\Source');
            return new XmlStringSitemap($config, $source);
        });
    }
}
