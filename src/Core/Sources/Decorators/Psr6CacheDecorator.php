<?php declare(strict_types = 1);

namespace Statico\Core\Sources\Decorators;

use Statico\Core\Contracts\Sources\Source;
use Statico\Core\Objects\Document;
use Statico\Core\Utilities\Collection;
use Psr\Cache\CacheItemPoolInterface;

final class Psr6CacheDecorator implements Source
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var Source
     */
    private $source;

    public function __construct(CacheItemPoolInterface $cache, Source $source)
    {
        $this->cache = $cache;
        $this->source = $source;
    }

    public function all(): Collection
    {
        $item = $this->cache->getItem('Documents/all');
        if ($item->isHit()) {
            return $item->get();
        }
        $result = $this->source->all();
        $item->set($result);
        $this->cache->save($item);
        return $result;
    }

    public function find(string $name): ?Document
    {
        $item = $this->cache->getItem('Documents/find/'.$name);
        if ($item->isHit()) {
            return $item->get();
        }
        $result = $this->source->find($name);
        $item->set($result);
        $this->cache->save($item);
        return $result;
    }
}
