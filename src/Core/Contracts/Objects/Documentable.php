<?php declare(strict_types = 1);

namespace Statico\Core\Contracts\Objects;

use Statico\Core\Objects\Document;

interface Documentable
{
    public function getContent(): string;

    public function setContent(string $data): Document;

    public function getField(string $key): string;

    public function setField(string $key, string $value): Document;

    public function getPath(): string;

    public function setPath(string $path): Document;

    public function getFields(): array;
}
