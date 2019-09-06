<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Objects;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Objects\MarkdownDocument;

final class DocumentTest extends TestCase
{
    public function testCreate()
    {
        $doc = new MarkdownDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals('This is my content', $doc->getContent());
        $this->assertEquals('My Page', $doc->getField('title'));
        $this->assertEquals('custom.html', $doc->getField('layout'));
        $this->assertEquals('foo', $doc->getPath());
    }

    public function testTostring()
    {
        $doc = new MarkdownDocument();
        $doc->setContent('This is my content');
        $this->assertEquals('This is my content', $doc->__toString());
    }

    public function testSet()
    {
        $doc = new MarkdownDocument();
        $doc->content = 'This is my content';
        $doc->title = 'My Page';
        $doc->layout = 'custom.html';
        $doc->path = 'foo';
        $this->assertEquals('This is my content', $doc->getContent());
        $this->assertEquals('My Page', $doc->getField('title'));
        $this->assertEquals('custom.html', $doc->getField('layout'));
        $this->assertEquals('foo', $doc->getPath());
    }

    public function testGet()
    {
        $doc = new MarkdownDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals('This is my content', $doc->content);
        $this->assertEquals('My Page', $doc->title);
        $this->assertEquals('custom.html', $doc->layout);
        $this->assertEquals('foo', $doc->path);
    }

    public function testGetFields()
    {
        $doc = new MarkdownDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals([
            'title' => 'My Page',
            'layout' => 'custom.html'
        ], $doc->getFields());
    }

    public function testJsonSerialize()
    {
        $doc = new MarkdownDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals([
            'title' => 'My Page',
            'layout' => 'custom.html',
            'content' => 'This is my content',
            'url' => '/foo'
        ], $doc->jsonSerialize());
    }
}
