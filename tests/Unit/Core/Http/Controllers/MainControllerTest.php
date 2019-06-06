<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Http\Controllers\MainController;
use Statico\Core\Objects\Document;

final class MainControllerTest extends TestCase
{
    public function testGetResponse()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $doc = (new Document)
            ->setField('title', 'Foo')
            ->setPath('foo.md')
            ->setContent('foo');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn($doc);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $view->shouldReceive('render')->with(
            $response,
            'default.html',
            ['title' => 'Foo', 'content' => 'foo']
        )->once();
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view
        );
        $controller->index($request, ['name' => 'foo']);
    }

    public function test404()
    {
        $this->expectException('League\Route\Http\Exception\NotFoundException');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn(null);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view
        );
        $controller->index($request, ['name' => 'foo']);
    }
}
