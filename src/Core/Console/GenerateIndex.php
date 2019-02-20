<?php declare(strict_types = 1);

namespace Statico\Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\Flysystem\MountManager;
use Mni\FrontYAML\Parser;
use Matthewbdaly\Proper\Collection;

final class GenerateIndex extends Command
{
    /**
     * @var MountManager
     */
    protected $manager;

    /**
     * @var Parser
     */
    protected $parser;

    public function __construct(MountManager $manager, Parser $parser)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->parser = $parser;
    }
    
    protected function configure(): void
    {
        $this->setName('index:generate')
             ->setDescription('Generates the search index')
             ->setHelp('This command will generate the search index file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $files = $this->manager->listContents('content://', true);
        $documents = new Collection;
        foreach ($files as $file) {
            if ($file['type'] == 'dir') {
                continue;
            }
            $content = $this->manager->read('content://'.$file['path']);
            $documents[] = $this->parser->parse($content);
        }
    }
}
