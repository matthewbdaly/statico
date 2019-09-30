<?php declare(strict_types=1);

namespace Statico\Core\Contracts\Sources;

use Statico\Core\Contracts\Utilities\Collectable;
use Statico\Core\Contracts\Objects\Document;

interface Source
{
    public function all(): Collectable;

    public function find(string $name): ?Document;
}
