<?php declare(strict_types = 1);

namespace Statico\Core;

use Psr\Http\Message\RequestInterface;

class Kernel
{
    public function bootstrap();

    public function handle(RequestInterface $request);
}
