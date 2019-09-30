<?php

declare(strict_types=1);

namespace Statico\Core\Contracts\Exceptions;

use Throwable;
use Whoops\Exception\Inspector;
use Whoops\RunInterface;

interface Handler
{
    public function __invoke(Throwable $exception, Inspector $inspector, RunInterface $run): void;
}
