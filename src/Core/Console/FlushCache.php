<?php declare(strict_types = 1);

namespace Statico\Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Cache\CacheItemPoolInterface;

final class FlushCache extends Command
{
    /**
     * @var CacheItemPoolInterface
     */
    protected $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        parent::__construct();
        $this->cache = $cache;
    }
    
    protected function configure(): void
    {
        $this->setName('cache:flush')
             ->setDescription('Flushes the cache')
             ->setHelp('This command will flush the cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->cache->purge();
    }
}
