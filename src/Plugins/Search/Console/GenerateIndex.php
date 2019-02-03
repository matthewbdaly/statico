<?php declare(strict_types = 1);

namespace Statico\Plugins\Search\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateIndex extends Command
{
    protected function configure(): void
    {
        $this->setName('index')
            ->setDescription('Generate search index')
            ->setHelp('This command generates the search index');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        throw new \Exception('Not implemented');
    }
}
