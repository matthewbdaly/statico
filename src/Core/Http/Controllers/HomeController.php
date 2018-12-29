<?php declare(strict_types = 1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return $this->response;
    }
}
