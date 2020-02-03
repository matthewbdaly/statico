<?php

declare(strict_types=1);

namespace Statico\Plugins\PHPCRSource\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Jackalope\Repository;
use Jackalope\RepositoryFactoryDoctrineDBAL;

class PHPCRRepositoryProvider extends AbstractServiceProvider
{
    protected $provides = [
        'PHPCR\RepositoryInterface',
        'PHPCR\SessionInterface',
    ];

    public function register(): void
    {
        // Register items
        $container = $this->getContainer();
        $container->add('PHPCR\RepositoryInterface', function () use ($container) {
            $dbConn = $container->get('Doctrine\DBAL\Connection');
            $factory = new RepositoryFactoryDoctrineDBAL();

            return $factory->getRepository(
                ['jackalope.doctrine_dbal_connection' => $dbConn]
            );
        });
        $container->add('PHPCR\SessionInterface', function () use ($container) {
            $workspace = getenv('PHPCR_WORKSPACE');
            $repository = $container->get('PHPCR\RepositoryInterface');
            $credentials = new \PHPCR\SimpleCredentials(null, null);
            $session = $repository->login($credentials, $workspace);
            return $session;
        });
    }
}
