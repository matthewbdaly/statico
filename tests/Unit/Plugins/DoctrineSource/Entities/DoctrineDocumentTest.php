<?php declare(strict_types = 1);

namespace Tests\Unit\Plugins\DoctrineSource\Entities;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DoctrineSource\Entities\DoctrineDocument;

final class DoctrineDocumentTest extends TestCase
{
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
}
