<?php declare(strict_types = 1);

namespace Statico\Plugins\DoctrineSource\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

class DoctrineProvider extends AbstractServiceProvider
{
    protected $provides = [
        'Doctrine\DBAL\Connection',
        'Doctrine\ORM\EntityManager',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('Doctrine\DBAL\Connection', function () {
            $dbParams = array(
                'url' => getenv('DB_URL'),
            );
            return DriverManager::getConnection($dbParams);
        });
        $container->add('Doctrine\ORM\EntityManager', function () use ($container) {
            $paths = ['app/Doctrine/Entities'];
            $isDevMode = false;
            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
            return EntityManager::create($container->get('Doctrine\DBAL\Connection'), $config);
        });
    }
}
