<?php

declare(strict_types=1);

namespace Statico\Core\Views\Functions;

use Statico\Core\Services\Navigator;

final class Navigation
{
    /**
     * @var Navigator
     */
    private $nav;

    public function __construct(Navigator $nav)
    {
        $this->nav = $nav;
    }

    public function __invoke()
    {
        return $this->nav->__invoke();
    }
}
