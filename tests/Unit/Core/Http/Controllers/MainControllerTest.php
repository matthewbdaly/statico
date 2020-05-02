<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Http\Controllers;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Core\Http\Controllers\MainController;
use Statico\Core\Objects\MarkdownDocument;
use DateTime;

final class MainControllerTest extends TestCase
{
    public function testGetResponse()
    {
        $emitter = m::mock('League\Event\EmitterInterface');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $timestamp = (new DateTime())->setTimestamp(1568840820);
        $response->shouldReceive('withAddedHeader')
            ->with('Last-Modified', $timestamp->format('D, d M Y H:i:s') . ' GMT')
            ->once()
            ->andReturn($response);
        $doc = (new MarkdownDocument())
            ->setField('title', 'Foo')
            ->setPath('foo.md')
            ->setContent('foo')
            ->setUpdatedAt($timestamp);
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn($doc);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $view->shouldReceive('render')->with(
            $response,
            'default.html',
            [
             'title'   => 'Foo',
             'content' => 'foo',
            ]
        )->once();
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view,
            $emitter
        );
        $controller->index($request, ['name' => 'foo']);
    }

    public function testPostResponse()
    {
        $emitter = m::mock('League\Event\EmitterInterface');
        $emitter->shouldReceive('emit')->with('Statico\Core\Events\FormSubmitted')->once();
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $doc = (new MarkdownDocument())
            ->setField('title', 'Foo')
            ->setField('forms', ['contact'])
            ->setPath('foo.md')
            ->setContent('foo');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn($doc);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $view->shouldReceive('render')->with(
            $response,
            'default.html',
            [
             'title'   => 'Foo',
             'content' => 'foo',
             'forms'   => ['contact'],
            ]
        )->once();
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view,
            $emitter
        );
        $controller->submit($request, ['name' => 'foo']);
    }

    public function testPostResponseToUnregisteredForm()
    {
        $emitter = m::mock('League\Event\EmitterInterface');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $doc = (new MarkdownDocument())
            ->setField('title', 'Foo')
            ->setPath('foo.md')
            ->setContent('foo');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn($doc);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view,
            $emitter
        );
        $response = $controller->submit($request, ['name' => 'foo']);
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function test404()
    {
        $this->expectException('League\Route\Http\Exception\NotFoundException');
        $emitter = m::mock('League\Event\EmitterInterface');
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $source = m::mock('Statico\Core\Contracts\Sources\Source');
        $source->shouldReceive('find')->once()->andReturn(null);
        $view = m::mock('Statico\Core\Contracts\Views\Renderer');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $controller = new MainController(
            $response,
            $source,
            $view,
            $emitter
        );
        $controller->index($request, ['name' => 'foo']);
    }
}
