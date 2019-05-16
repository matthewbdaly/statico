<?php declare(strict_types = 1);

namespace Statico\Core\Objects;

use Statico\Core\Contracts\Objects\Documentable;
use JsonSerializable;

abstract class Content implements Documentable, JsonSerializable
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

    public function setContent(string $data): Content
    {
        $this->content = $data;
        return $this;
    }

    public function getField(string $key): string
    {
        return $this->data[$key];
    }

    public function setField(string $key, string $value): Content
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Content
    {
        $this->path = $path;
        return $this;
    }

    public function __toString(): string
    {
        return $this->content;
    }

    public function __get(string $name): string
    {
        if ($name == 'content') {
            return $this->getContent();
        }
        if ($name == 'path') {
            return $this->getPath();
        }
        return $this->getField($name);
    }

    public function __set(string $name, string $value): Content
    {
        if ($name == 'content') {
            $this->setContent($value);
        } else if ($name == 'path') {
            $this->setPath($value);
        } else {
            $this->setField($name, $value);
        }
        return $this;
    }

    public function getFields(): array
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): array
    {
        $data = $this->getFields();
        $data['content'] = $this->getContent();
        $data['path'] = $this->getPath();
        return $data;
    }
}
