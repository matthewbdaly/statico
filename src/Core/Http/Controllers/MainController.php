<?php

declare(strict_types=1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Views\Renderer;
use League\Route\Http\Exception\NotFoundException;
use Statico\Core\Contracts\Sources\Source;
use League\Event\EmitterInterface;
use Statico\Core\Events\FormSubmitted;
use Laminas\Diactoros\Response\EmptyResponse;

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

    /**
     * @var EmitterInterface
     */
    protected $emitter;

    public function __construct(ResponseInterface $response, Source $source, Renderer $view, EmitterInterface $emitter)
    {
        $this->response = $response;
        $this->source = $source;
        $this->view = $view;
        $this->emitter = $emitter;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $name = isset($args['name']) ? $args['name'] : 'index';
        if (!$document = $this->source->find($name)) {
            throw new NotFoundException('Page not found');
        }
        $data = $document->getFields();
        $data['content'] = $document->getContent();
        $layout = isset($data['layout']) ? $data['layout'] . '.html' : 'default.html';
        $response = $this->response->withAddedHeader('Last-Modified', $document->getUpdatedAt()->format('D, d M Y H:i:s') . ' GMT');
        return $this->view->render($response, $layout, $data);
    }

    public function submit(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $name = isset($args['name']) ? $args['name'] : 'index';
        if (!$document = $this->source->find($name)) {
            throw new NotFoundException('Page not found');
        }
        $data = $document->getFields();
        if (!isset($data['forms'])) {
            return new EmptyResponse(405);
        }
        $data['content'] = $document->getContent();
        $layout = isset($data['layout']) ? $data['layout'] . '.html' : 'default.html';
        $event = new FormSubmitted();
        $this->emitter->emit($event);
        return $this->view->render($this->response, $layout, $data);
    }
}
