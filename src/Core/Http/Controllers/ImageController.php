<?php

declare(strict_types=1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use League\Route\Http\Exception\NotFoundException;
use Statico\Core\Events\FormSubmitted;
use Zend\Diactoros\Response\EmptyResponse;
use League\Glide\Server;

final class ImageController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Server
     */
    private $glide;

    public function __construct(ResponseInterface $response, Server $glide)
    {
        $this->response = $response;
        $this->glide = $glide;
    }

    public function get(ServerRequestInterface $request, array $args): ResponseInterface
    {
        eval(\Psy\Sh());
        dd($args);
    }
}
