<?php

declare(strict_types=1);

namespace Statico\Plugins\DoctrineSource\Entities;

use DateTime;
use Statico\Core\Contracts\Objects\Document;

/**
 * @Entity
 * @Table(name="documents")
 */
class DoctrineDocument implements Document
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string",length=200)
     */
    private $path = '';

    /**
     * @Column(type="text")
     */
    private $content = '';

    /**
     * @Column(type="json")
     */
    private $data;
      
    /**
     * @Column(type="datetime"))
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Getter for content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $data): Document
    {
        $this->content = $data;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getField(string $key)
    {
        return $this->data[$key];
    }

    /**
     * {@inheritDoc}
     */
    public function setField(string $key, $value): Document
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getUrl(): string
    {
        return '/' . preg_replace('/index$/', '', $this->getPath());
    }

    public function setPath(string $path): Document
    {
        $this->path = $path;
        return $this;
    }

    public function getFields(): array
    {
        return $this->data;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Document
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
    }
}
