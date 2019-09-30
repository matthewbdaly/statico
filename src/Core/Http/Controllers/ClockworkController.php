<?php

declare(strict_types=1);

namespace Statico\Core\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Clockwork\Support\Vanilla\Clockwork;

final class ClockworkController
{
    /**
     * @var Clockwork
     */
    private $clockwork;

    public function __construct(Clockwork $clockwork)
    {
        $this->clockwork = $clockwork;
    }

    public function process(ServerRequestInterface $request, $requestName)
    {
        return new JsonResponse($this->clockwork->getMetadata($requestName['request']));
    }
}
