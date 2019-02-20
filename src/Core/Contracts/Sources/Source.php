<?php declare(strict_types = 1);

namespace Statico\Core\Contracts\Sources;

interface Source
{
    public function all(): array;

    public function find(string $name);
}
