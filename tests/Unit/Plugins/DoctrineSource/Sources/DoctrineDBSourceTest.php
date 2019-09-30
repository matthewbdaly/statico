<?php declare(strict_types = 1);

namespace Tests\Unit\Plugins\DoctrineSource\Sources;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DoctrineSource\Sources\DoctrineDB;
use Statico\Core\Utilities\Collection;

final class DoctrineDBSourceTest extends TestCase
{
    public function testAll()
    {
        $this->markTestIncomplete();
        $document = m::mock('Statico\Plugins\DoctrineSource\Entities\DoctrineDocument');
        $repo = m::mock('Doctrine\Common\Persistence\ObjectRepository');
        $repo->shouldReceive('findAll')->once()->andReturn([$document]);
        $em = m::mock('Doctrine\ORM\EntityManager');
        $em->shouldReceive('getRepository')->once()->andReturn($repo);
        $source = new DoctrineDB($em);
        $response = $source->all();
        $this->assertInstanceOf('Statico\Core\Utilities\Collection', $response);
        $this->assertEquals($document, $response[0]);
    }

    public function testFind()
    {
        $document = m::mock('Statico\Plugins\DoctrineSource\Entities\DoctrineDocument');
        $repo = m::mock('Doctrine\Common\Persistence\ObjectRepository');
        $repo->shouldReceive('findOneBy')
            ->with(['path' => 'foo/'])
            ->once()
            ->andReturn($document);
        $em = m::mock('Doctrine\ORM\EntityManager');
        $em->shouldReceive('getRepository')->once()->andReturn($repo);
        $source = new DoctrineDB($em);
        $response = $source->find('foo/');
        $this->assertEquals($document, $response);
    }
}
