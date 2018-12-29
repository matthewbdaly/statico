<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mni\FrontYAML\Parser;

class MainController
{
    protected $response;

    protected $parser;

    public function __construct(ResponseInterface $response, Parser $parser)
    {
        $this->response = $response;
        $this->parser = $parser;
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

            return $this->view->render($response, $layout, $data);
        } else {
            throw new NotFoundException($request, $response);
        }
    }
}
