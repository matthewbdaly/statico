<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mni\FrontYAML\Parser;
use Statico\Core\Contracts\Views\Renderer;
use Statico\Core\Contracts\Paths\Resolver;
use League\Route\Http\Exception\NotFoundException;

final class MainController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var Renderer
     */
    protected $view;

    /**
     * @var Resolver
     */
    protected $resolver;

    public function __construct(ResponseInterface $response, Parser $parser, Renderer $view, Resolver $resolver)
    {
        $this->response = $response;
        $this->parser = $parser;
        $this->view = $view;
        $this->resolver = $resolver;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        // Does that page exist?
        $name = isset($args['name']) ? $args['name'] : 'index';
        if (!$filename = $this->resolver->resolve($name)) {
            throw new NotFoundException('Page not found');
        }

        // Get content
        $rawcontent = file_get_contents($filename);
        $document = $this->parser->parse($rawcontent);

        // Get title
        $data = $document->getYAML();
        $data['content'] = $document->getContent();
        $title = $data['title'];
        $layout = isset($data['layout']) ? $data['layout'].'.html' : 'default.html';

        return $this->view->render($this->response, $layout, $data);
    }
}
