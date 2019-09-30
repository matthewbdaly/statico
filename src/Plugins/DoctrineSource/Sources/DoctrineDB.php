<?php declare(strict_types=1);

namespace Statico\Plugins\DoctrineSource\Sources;

use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Contracts\Objects\Document;
use Statico\Core\Contracts\Utilities\Collectable;
use Statico\Core\Utilities\LazyCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;
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

    public function all(): Collectable
    {
        return LazyCollection::make(function () {
            $query = $this->getRepository()->createQueryBuilder('documents')->getQuery();
            foreach ($query->iterate() as $row) {
                yield $row;
            }
        });
    }

    public function find(string $name): ?Document
    {
        return $this->getRepository()->findOneBy([
            'path' => $name
        ]);
    }

    private function getRepository(): ObjectRepository
    {
        return $this->em->getRepository(DoctrineDocument::class);
    }
}
