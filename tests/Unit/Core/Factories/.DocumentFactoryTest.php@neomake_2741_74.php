<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Objects\Document;
use Statico\Core\Factories\DocumentFactory;
use Mockery as m;

final class DocumentFactoryTest extends TestCase
{
    public function testFromYaml()
    {
        $document = m::mock('Mni\FrontYAML\Document');
        $document->shouldReceive('getYAML')->once()
            ->andReturn([
                'title' => 'Foo',
                'layout' => 'custom.html'
            ]);
        $document->shouldReceive('getContent')->once()
            ->andReturn('My content');
        $response = DocumentFactory::fromYaml($document, 'foo.md');
        $this->assertInstanceOf(Document::class, $response);
        $this->assertEquals('My content', $response->getContent());
        $this->assertEquals('Foo', $response->getField('title'));
        $this->assertEquals('custom.html', $response->getField('layout'));
        $this->assertEquals('foo.md', $response->getPath());
    }
}
