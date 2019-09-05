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
    private $name = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
