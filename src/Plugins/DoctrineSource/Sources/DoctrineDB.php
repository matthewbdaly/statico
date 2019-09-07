<?php declare(strict_types=1);

namespace Statico\Plugins\DoctrineSource\Sources;

use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Objects\Document;
use Statico\Core\Utilities\Collection;
use Doctrine\ORM\EntityManager;
use Statico\Plugins\DoctrineSource\Entities\DoctrineDocument;

final class DoctrineDB implements Source
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function all(): Collection
    {
    }

    public function find(string $name): Document
    {
    }
}
