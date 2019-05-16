<?php declare(strict_types = 1);

namespace Statico\Core\Contracts\Objects;

use Statico\Core\Objects\Content;

interface Documentable
{
    public function getContent(): string;

    public function setContent(string $data): Content;

    public function getField(string $key): string;

    public function setField(string $key, string $value): Content;

    public function getPath(): string;

    public function setPath(string $path): Content;

    public function getFields(): array;
}
