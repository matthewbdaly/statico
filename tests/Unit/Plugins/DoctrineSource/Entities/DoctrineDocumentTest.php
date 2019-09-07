<?php declare(strict_types = 1);

namespace Tests\Unit\Plugins\DoctrineSource\Entities;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DoctrineSource\Entities\DoctrineDocument;
use Tests\Traits\SetsPrivateProperties;

final class DoctrineDocumentTest extends TestCase
{
    use SetsPrivateProperties;

    public function testCreate()
    {
        $doc = new DoctrineDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals('This is my content', $doc->getContent());
        $this->assertEquals('My Page', $doc->getField('title'));
        $this->assertEquals('custom.html', $doc->getField('layout'));
        $this->assertEquals('foo', $doc->getPath());
    }

    public function testGetFields()
    {
        $doc = new DoctrineDocument();
        $doc->setContent('This is my content');
        $doc->setField('title', 'My Page');
        $doc->setField('layout', 'custom.html');
        $doc->setPath('foo');
        $this->assertEquals([
            'title' => 'My Page',
            'layout' => 'custom.html'
        ], $doc->getFields());
    }

    public function testGetId()
    {
        $doc = new DoctrineDocument();
        $this->setPrivateProperty($doc, 'id', 1);
        $this->assertEquals(1, $doc->getId());
    }

    public function testGetUrl()
    {
        $doc = new DoctrineDocument();
        $doc->setPath('foo');
        $this->assertEquals('/foo', $doc->getUrl());
    }
}