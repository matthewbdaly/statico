<?php

declare(strict_types=1);

namespace Statico\Plugins\PHPCRSource\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\PHPCR\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\Configuration;

class DocumentManagerProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Doctrine\ODM\PHPCR\DocumentManagerInterface',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Doctrine\ODM\PHPCR\DocumentManagerInterface', function () use ($container) {
            $session = $container->get('PHPCR\SessionInterface');
            $reader = new AnnotationReader();
            $driver = new AnnotationDriver($reader, ['app/Doctrine/Entities']);

            $config = new Configuration();
            $config->setMetadataDriverImpl($driver);

            return DocumentManager::create($session, $config);
        });
    }
}
