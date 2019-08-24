<?php declare(strict_types=1);

namespace Statico\Core\Contracts\Sources;

use Statico\Core\Utilities\Collection;
use Statico\Core\Objects\Document;

interface Source
{
    public function all(): Collection;

    public function find(string $name): ?Document;
}
