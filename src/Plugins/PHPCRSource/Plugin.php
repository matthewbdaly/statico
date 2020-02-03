<?php

declare(strict_types=1);

namespace Statico\Plugins\PHPCRSource;

use Statico\Core\Contracts\Plugin as PluginContract;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Jackalope\Tools\Console\Command\InitDoctrineDbalCommand;
use PHPCR\Util\Console\Command;
use Symfony\Component\Console\Helper\HelperSet;

final class Plugin implements PluginContract
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Application
     */
    private $console;

    public function __construct(ContainerInterface $container, Application $console)
    {
        $this->container = $container;
        $this->console = $console;
    }

    public function register(): void
    {
        $this->registerServiceProvider();
        $this->registerConsoleCommands();
    }

    private function registerServiceProvider(): void
    {
        $this->container->addServiceProvider('Statico\Plugins\PHPCRSource\Providers\DocumentManagerProvider');
        $this->container->addServiceProvider('Statico\Plugins\PHPCRSource\Providers\PHPCRRepositoryProvider');
    }

    private function registerConsoleCommands(): void
    {
        $helperSet = new HelperSet();
        $this->console->setCatchExceptions(true);
        if (isset($argv[1])
            && !preg_match('/(jackalope:init:dbal|list|help|orm.*|dbal.*)/', $argv[1])
        ) {
            $helperSet->set($this->container->get('PHPCR\Util\Console\Helper\PhpcrHelper'), 'phpcr');
            $helperSet->set($this->container->get('PHPCR\Util\Console\Helper\PhpcrConsoleDumperHelper'), 'phpcr_console_dumper');
        } else if (isset($argv[1]) && $argv[1] == 'jackalope:init:dbal') {
            // special case: the init command needs the db connection, but a session is impossible if the db is not yet initialized
            $helperSet->set($this->container->get('Jackalope\Tools\Console\Helper\DoctrineDbalHelper'), 'connection');
        }

        $this->console->setHelperSet($helperSet);
        $this->console->addCommands([
            new \PHPCR\Util\Console\Command\NodeDumpCommand(),
            new \PHPCR\Util\Console\Command\NodeMoveCommand(),
            new \PHPCR\Util\Console\Command\NodeRemoveCommand(),
            new \PHPCR\Util\Console\Command\NodesUpdateCommand(),
            new \PHPCR\Util\Console\Command\NodeTouchCommand(),
            new \PHPCR\Util\Console\Command\NodeTypeListCommand(),
            new \PHPCR\Util\Console\Command\NodeTypeRegisterCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceCreateCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceDeleteCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceExportCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceImportCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceListCommand(),
            new \PHPCR\Util\Console\Command\WorkspacePurgeCommand(),
            new \PHPCR\Util\Console\Command\WorkspaceQueryCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\DocumentMigrateClassCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\DocumentConvertTranslationCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\GenerateProxiesCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\DumpQueryBuilderReferenceCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\InfoDoctrineCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\VerifyUniqueNodeTypesMappingCommand(),
            new \Doctrine\ODM\PHPCR\Tools\Console\Command\RegisterSystemNodeTypesCommand(),
            new Command\NodeDumpCommand(),
            new Command\NodeMoveCommand(),
            new Command\NodeRemoveCommand(),
            new Command\NodeTouchCommand(),

            new Command\NodeTypeListCommand(),
            new Command\NodeTypeRegisterCommand(),

            new Command\WorkspaceCreateCommand(),
            new Command\WorkspaceDeleteCommand(),
            new Command\WorkspaceExportCommand(),
            new Command\WorkspaceImportCommand(),
            new Command\WorkspaceListCommand(),
            new Command\WorkspacePurgeCommand(),
            new Command\WorkspaceQueryCommand(),

            new InitDoctrineDbalCommand(),
        ]);
    }
}
