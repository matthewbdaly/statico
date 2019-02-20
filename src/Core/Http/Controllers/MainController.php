<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mni\FrontYAML\Parser;
use Statico\Core\Contracts\Views\Renderer;
use League\Route\Http\Exception\NotFoundException;
use League\Flysystem\MountManager;

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
     * @var MountManager
     */
    protected $manager;

    public function __construct(ResponseInterface $response, Parser $parser, Renderer $view, MountManager $manager)
    {
        $this->response = $response;
        $this->parser = $parser;
        $this->view = $view;
        $this->manager = $manager;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        // Does that page exist?
        $name = isset($args['name']) ? $args['name'] : 'index';
        $path = "content://".rtrim($name, '/') . '.md';
        if (!$this->manager->has($path)) {
            throw new NotFoundException('Page not found');
        }

        // Get content
        $rawcontent = $this->manager->read($path);
        $document = $this->parser->parse($rawcontent);

        // Get title
        $data = $document->getYAML();
        $data['content'] = $document->getContent();
        $title = $data['title'];
        $layout = isset($data['layout']) ? $data['layout'].'.html' : 'default.html';

        return $this->view->render($this->response, $layout, $data);
    }
}
