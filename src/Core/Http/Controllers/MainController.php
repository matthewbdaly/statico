<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Views\Renderer;
use League\Route\Http\Exception\NotFoundException;
use Statico\Core\Contracts\Sources\Source;

final class MainController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Source
     */
    protected $source;

    /**
     * @var Renderer
     */
    protected $view;

    public function __construct(ResponseInterface $response, Source $source, Renderer $view)
    {
        $this->response = $response;
        $this->source = $source;
        $this->view = $view;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $name = isset($args['name']) ? $args['name'] : 'index';
        if (!$document = $this->source->find($name)) {
            throw new NotFoundException('Page not found');
        }
        $data = $document->getFields();
        $data['content'] = $document->getContent();
        $title = $data['title'];
        $layout = isset($data['layout']) ? $data['layout'].'.html' : 'default.html';
        return $this->view->render($this->response, $layout, $data);
    }
}
