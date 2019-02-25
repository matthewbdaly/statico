<?php declare(strict_types = 1);

namespace Statico\Core\Objects;

final class Document
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->content = '';
        $this->data = [];
        $this->path = '';
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $data): Document
    {
        $this->content = $data;
        return $this;
    }

    public function getField(string $key): string
    {
        return $this->data[$key];
    }

    public function setField(string $key, string $value): Document
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Document
    {
        $this->path = $path;
        return $this;
    }

    public function __toString(): string
    {
        return $this->content;
    }

    public function __set(string $name, string $value)
    {
        if ($name == 'content') {
            $this->setContent($value);
        } else if ($name == 'path') {
            $this->setPath($value);
        } else {
            $this->setField($name, $value);
        }
    }
}
