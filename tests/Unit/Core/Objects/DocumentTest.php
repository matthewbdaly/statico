<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Objects;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Objects\Document;

class DocumentTest extends TestCase
{
    public function testCreate()
    {
        $doc = new Document;
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo.md');
        $this->assertEquals('This is my content', $doc->getContent());
        $this->assertEquals('My Page', $doc->getField('title'));
        $this->assertEquals('custom.html', $doc->getField('layout'));
        $this->assertEquals('foo.md', $doc->getPath());
    }

    public function testTostring()
    {
        $doc = new Document;
        $doc->setContent('This is my content');
        $this->assertEquals('This is my content', $doc->__toString());
    }

    public function testSet()
    {
        $doc = new Document;
        $doc->content = 'This is my content';
        $doc->title = 'My Page';
        $doc->layout = 'custom.html';
        $doc->path = 'foo.md';
        $this->assertEquals('This is my content', $doc->getContent());
        $this->assertEquals('My Page', $doc->getField('title'));
        $this->assertEquals('custom.html', $doc->getField('layout'));
        $this->assertEquals('foo.md', $doc->getPath());

    }
}
