<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Console\GenerateSitemap;
use Symfony\Component\Console\Tester\CommandTester;

final class GenerateSitemapTest extends TestCase
{
    public function testExecute()
    {
        $generator = m::mock('Statico\Core\Contracts\Generators\Sitemap');
        $generator->shouldReceive('__invoke')->once()->andReturn('foo');
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('put')
            ->with('assets://sitemap.xml', 'foo')
            ->once();
        $cmd = new GenerateSitemap($generator, $manager);
        $tester = new CommandTester($cmd);
        $tester->execute([]);
        $this->assertEquals('sitemap:generate', $cmd->getName());
        $this->assertEquals('Generates the sitemap', $cmd->getDescription());
        $this->assertEquals('This command will generate the sitemap', $cmd->getHelp());
    }
}
