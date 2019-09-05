<?php declare(strict_types=1);

namespace Statico\Core\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Container\ContainerInterface;
use Psy\Shell as Psysh;
use Psy\Configuration;

final class Shell extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Psysh
     */
    protected $shell;
    
    public function __construct(ContainerInterface $container, Psysh $shell)
    {
        parent::__construct();
        $this->container = $container;
        $this->shell = $shell;
    }
    
    protected function configure(): void
    {
        $this->setName('shell')
                ->setDescription('Runs an interactive shell')
                ->setHelp('This command runs an interactive shell');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->shell->setScopeVariables([
            'container' => $this->container
        ]);
        $this->shell->run();
    }
}
