<?php

namespace Statico\Core\Contracts\Services;

use Statico\Core\Objects\Navigation\Container;

interface Navigator
{
    public function __invoke(): Container;
}
