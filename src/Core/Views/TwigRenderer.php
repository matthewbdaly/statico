<?php declare(strict_types = 1);

namespace Statico\Core\Views;

use Statico\Core\Contracts\Views\Renderer;
use Psr\Http\Message\ResponseInterface;
use Twig_Environment;

final class TwigRenderer implements Renderer
{
    protected $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $tpl = $this->twig->load($template);
        $response->getBody()->write($tpl->render($data));
        return $response;
    }        
}
