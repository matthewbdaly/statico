<?php declare(strict_types = 1);

namespace Tests\Unit\Plugins\DynamicSearch\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Statico\Plugins\DynamicSearch\Http\Controllers\SearchController;
use Statico\Core\Utilities\Collection;

final class SearchControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = Collection::make([['foo']]);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('all')->once()->andReturn($response);
        $controller = new SearchController($source);
        $result = $controller->index();
        $this->assertInstanceOf('Zend\Diactoros\Response\JsonResponse', $result);
        $this->assertEquals('[["foo"]]', $result->getBody()->getContents());
    }
}
