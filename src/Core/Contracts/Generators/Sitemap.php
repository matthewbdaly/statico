<?php declare(strict_types = 1);

namespace Statico\Core\Contracts\Generators;

/**
 * Interface for sitemap generators
 */
interface Sitemap
{
    public function __invoke();
}
