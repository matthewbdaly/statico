<?php declare(strict_types = 1);

namespace Tests\Unit\Views;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Views\TwigRenderer;

final class TwigRendererTest extends TestCase
{
    public function testRenderer(): void
    {
        $twig = m::mock('Twig_Environment');
        $twig->shouldReceive('load')->with('foo.html')->once()->andReturn($twig);
        $twig->shouldReceive('render')->with(['Foo'])->once()->andReturn(['Foo']);
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->once()->andReturn($response);
        $response->shouldReceive('write')->once()->andReturn($response);
        $renderer = new TwigRenderer($twig);
        $renderer->render($response, 'foo.html', ['Foo']);
    }
}
