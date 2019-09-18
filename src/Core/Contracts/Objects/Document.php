<?php declare(strict_types=1);

namespace Statico\Core\Contracts\Objects;

use DateTime;

interface Document
{
    public function getContent(): string;

    public function setContent(string $data): Document;

    /**
     * @return mixed
     */
    public function getField(string $key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setField(string $key, $value): Document;

    public function getPath(): string;

    public function getUrl(): string;

    public function setPath(string $path): Document;

    public function getFields(): array;

    public function getUpdatedAt(): DateTime;

    public function setUpdatedAt(DateTime $updatedAt): Document;
}
