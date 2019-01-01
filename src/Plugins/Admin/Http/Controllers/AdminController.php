<?php declare(strict_types = 1);

namespace Statico\Plugins\Admin\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Views\Renderer;

final class AdminController
{
    protected $response;

    protected $view;

    public function __construct(ResponseInterface $response, Renderer $view)
    {
        $this->response = $response;
        $this->view = $view;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        eval(\Psy\Sh());
        return $this->view->render($this->response, $layout, $data);
    }
}
