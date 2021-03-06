<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Plugins\DynamicSearch\Http\Controllers;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DynamicSearch\Http\Controllers\SearchController;
use PublishingKit\Utilities\Collections\Collection;

final class SearchControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = Collection::make([['foo']]);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn($response);
        $controller = new SearchController($source);
        $result = $controller->index();
        $this->assertInstanceOf('Laminas\Diactoros\Response\JsonResponse', $result);
        $this->assertEquals('[["foo"]]', $result->getBody()->getContents());
    }
}
