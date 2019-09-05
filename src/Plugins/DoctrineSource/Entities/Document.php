<?php declare(strict_types = 1);

namespace Statico\Plugins\DoctrineSource\Entities;

/**
 * @Entity
 * @Table(name="documents")
 */
class Document
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
    private $title = '';

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
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
}
