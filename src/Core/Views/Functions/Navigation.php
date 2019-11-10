<?php

declare(strict_types=1);

namespace Statico\Core\Views\Functions;

use Statico\Core\Services\Navigator;
use Twig\Markup;

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

    public function __invoke(): Markup
    {
        return new Markup($this->nav->__invoke()->__toString(), 'UTF-8');
    }
}
