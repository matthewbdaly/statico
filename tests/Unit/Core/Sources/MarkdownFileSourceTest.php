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
        $manager->shouldReceive('listContents')
            ->with('content://', true)
            ->once()
            ->andReturn([[
                'type' => 'dir',
                'path' => 'about'
            ], [
                'type' => 'file',
                'path' => 'foo.md'
            ]]);
        $manager->shouldReceive('read')->with('content://foo.md')
            ->once()
            ->andReturn('foo');
        $document = m::mock('Mni\FrontYAML\Document');
        $document->shouldReceive('getContent')->once()
            ->andReturn('My content');
        $document->shouldReceive('getYAML')->once()
            ->andReturn([
                'title' => 'Foo'
            ]);
        $parser = m::mock('Mni\FrontYAML\Parser');
        $parser->shouldReceive('parse')->with('foo')->once()
            ->andReturn($document);
        $source = new MarkdownFiles($manager, $parser);
        $response = $source->all();
        $this->assertCount(1, $response);
        $this->assertInstanceOf('Statico\Core\Objects\Document', $response[0]);
        $this->assertEquals('My content', $response[0]->content);
        $this->assertEquals('Foo', $response[0]->title);
        $this->assertEquals('foo.md', $response[0]->path);
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

    public function testFindEmpty()
    {
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')
            ->once()
            ->andReturn(true);
        $manager->shouldReceive('read')->with('content://foo.md')
            ->once()
            ->andReturn(null);
        $parser = m::mock('Mni\FrontYAML\Parser');
        $source = new MarkdownFiles($manager, $parser);
        $this->assertNull($source->find('foo'));
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
