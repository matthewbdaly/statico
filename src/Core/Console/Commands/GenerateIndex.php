<?php

declare(strict_types=1);

namespace Statico\Core\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Statico\Core\Contracts\Sources\Source;
use League\Flysystem\FilesystemInterface;

final class GenerateIndex extends Command
{
    /**
     * @var Source
     */
    protected $source;

    /**
     * @var FilesystemInterface
     */
    protected $manager;

    public function __construct(Source $source, FilesystemInterface $manager)
    {
        parent::__construct();
        $this->source = $source;
        $this->manager = $manager;
    }
    
    protected function configure(): void
    {
        $this->setName('index:generate')
                ->setDescription('Generates the search index')
                ->setHelp('This command will generate the search index file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $searchable = $this->source->all();
        $this->manager->put('assets://index.json', json_encode($searchable->toArray()));
    }
}
