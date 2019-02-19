<?php declare(strict_types = 1);

namespace Statico\Plugins\Admin\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Statico\Core\Contracts\Views\Renderer;

final class AdminController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Renderer
     */
    protected $view;

    public function __construct(ResponseInterface $response, Renderer $view)
    {
        $this->response = $response;
        $this->view = $view;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->view->render($this->response, '@admin/index.html');
    }
}
