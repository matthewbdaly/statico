<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Sources;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Sources\MarkdownFiles;

class MarkdownFileSourceTest extends TestCase
{
    public function testAll()
    {
        $manager = m::mock('League\Flysystem\MountManager');
        $parser = m::mock('Mni\FrontYAML\Parser');
        $source = new MarkdownFiles($manager, $parser);
        $source->all();
    }

    public function testFind()
    {
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')
            ->once()
            ->andReturn(true);
        $manager->shouldReceive('read')->with('content://foo.md')
            ->once()
            ->andReturn('foo');
        $document = m::mock('Mni\FrontYAML\Document');
        $parser = m::mock('Mni\FrontYAML\Parser');
        $parser->shouldReceive('parse')->with('foo')->once()
            ->andReturn($document);
        $source = new MarkdownFiles($manager, $parser);
        $this->assertEquals($document, $source->find('foo'));
    }

    public function testFindNull()
    {
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')
            ->once()
            ->andReturn(null);
        $parser = m::mock('Mni\FrontYAML\Parser');
        $source = new MarkdownFiles($manager, $parser);
        $this->assertNull($source->find('foo'));
    }
}
