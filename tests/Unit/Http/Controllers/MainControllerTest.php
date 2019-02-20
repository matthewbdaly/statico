<?php declare(strict_types = 1);

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Http\Controllers\MainController;

class MainControllerTest extends TestCase
{
    public function testGetResponse()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $doc = m::mock('Mni\FrontYAML\Document');
        $doc->shouldReceive('getYAML')->once()->andReturn([
            'title' => 'Foo'
        ]);
        $doc->shouldReceive('getContent')->once()->andReturn('foo');
        $parser = m::mock('Mni\FrontYAML\Parser');
        $parser->shouldReceive('parse')->with('foo')->andReturn($doc);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $view->shouldReceive('render')->with(
            $response,
            'default.html',
            ['title' => 'Foo', 'content' => 'foo']
        )->once();
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')->once()
            ->andReturn(true);
        $manager->shouldReceive('read')->with('content://foo.md')->once()
            ->andReturn('foo');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $parser,
            $view,
            $manager
        );
        $controller->index($request, ['name' => 'foo']);
    }

    public function testEmpty()
    {
        $this->expectException('League\Route\Http\Exception\NotFoundException');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $parser = m::mock('Mni\FrontYAML\Parser');
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')->once()
            ->andReturn(true);
        $manager->shouldReceive('read')->with('content://foo.md')->once()
            ->andReturn(null);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $parser,
            $view,
            $manager
        );
        $controller->index($request, ['name' => 'foo']);
    }

    public function test404()
    {
        $this->expectException('League\Route\Http\Exception\NotFoundException');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $parser = m::mock('Mni\FrontYAML\Parser');
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $manager = m::mock('League\Flysystem\MountManager');
        $manager->shouldReceive('has')->with('content://foo.md')->once()
            ->andReturn(false);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $parser,
            $view,
            $manager
        );
        $controller->index($request, ['name' => 'foo']);
    }
}
