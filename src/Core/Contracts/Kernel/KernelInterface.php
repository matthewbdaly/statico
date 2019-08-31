<?php

namespace Statico\Core\Contracts\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface KernelInterface
{
    /**
     * Handle a request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
