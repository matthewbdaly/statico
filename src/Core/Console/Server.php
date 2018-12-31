<?php declare(strict_types = 1);

namespace Statico\Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Server extends Command
{
    protected function configure(): void
    {
        $this->setName('server')
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, 'Which port should the server run on?')
            ->setDescription('Runs the development server')
            ->setHelp('This command runs the development server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if (!$port = $input->getOption('port')) {
            $port = 8000;
        }
        $output->writeln('Running PHP development server on port '.$port.'...');
        passthru('php -S localhost:'.$port.' -t '.getcwd().'/public');
    }
}
