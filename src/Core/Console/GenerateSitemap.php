<?php declare(strict_types = 1);

namespace Statico\Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Statico\Core\Traits\ParsesPath;
use Statico\Core\Contracts\Sources\Source;
use League\Flysystem\MountManager;
use SimpleXmlElement;

final class GenerateSitemap extends Command
{
    use ParsesPath;

    /**
     * @var Source
     */
    protected $source;

    /**
     * @var MountManager
     */
    protected $manager;

    public function __construct(Source $source, MountManager $manager)
    {
        parent::__construct();
        $this->source = $source;
        $this->manager = $manager;
    }
    
    protected function configure(): void
    {
        $this->setName('sitemap:generate')
             ->setDescription('Generates the sitemap')
             ->setHelp('This command will generate the sitemap');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $documents = $this->source->all();
        $xml = new SimpleXmlElement('<xml />');
        $urlset = $xml->addChild('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
');
        foreach ($documents as $document) {
            $item = $urlset->addChild('<url>');
            $item->addChild('loc', $this->parsePath($document->getPath()));
        }
        $this->manager->put('assets://sitemap.xml', $xml->asXml());
    }
}
