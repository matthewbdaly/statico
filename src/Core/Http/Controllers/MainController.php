<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mni\FrontYAML\Parser;
use Statico\Core\Contracts\Views\Renderer;

final class MainController
{
    protected $response;

    protected $parser;

    protected $view;

    public function __construct(ResponseInterface $response, Parser $parser, Renderer $view)
    {
        $this->response = $response;
        $this->parser = $parser;
        $this->view = $view;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        // Does that page exist?
        $name = isset($args['name']) ? $args['name'] : 'index';
        $filename = BASE_DIR.CONTENT_PATH. $name . '.md';
        if (file_exists($filename)) {
            // Get content
            $rawcontent = file_get_contents($filename);
            $document = $this->parser->parse($rawcontent);

            // Get title
            $data = $document->getYAML();
            $data['content'] = $document->getContent();
            $title = $data['title'];
            $layout = isset($data['layout']) ? $data['layout'].'.phtml' : 'default.phtml';

            return $this->view->render($this->response, $layout, $data);
        } else {
            throw new NotFoundException($request, $response);
        }
    }
}
