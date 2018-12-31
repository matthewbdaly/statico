<?php declare(strict_types = 1);

namespace Statico\Core\Contracts\Views;

use Psr\Http\Message\ResponseInterface;

interface Renderer
{
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface;
}
