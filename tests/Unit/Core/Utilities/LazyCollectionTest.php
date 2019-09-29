<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Utilities;

use Statico\Core\Utilities\LazyCollection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ReflectionClass;

final class LazyCollectionTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    protected function setUp()
    {
        $items = [];
        $this->collection = new LazyCollection(function () {
            for ($i = 0; $i < 5; $i++) {
                yield $i;
            }
        });
    }

    protected function tearDown()
    {
        $this->collection = null;
        $reflect = new ReflectionClass(LazyCollection::class);
        $macros = $reflect->getProperty('macros');
        $macros->setAccessible(true);
        $macros->setValue(null);
    }

    public function testCanBeCreated()
    {
        $collection = new LazyCollection(function () {
            for ($i = 0; $i < 5; $i++) {
                yield $i;
            }
        });
        $this->assertInstanceOf(LazyCollection::class, $collection);
    }

    public function testCanBeCalledStatically()
    {
        $this->collection = LazyCollection::make(function () {
            for ($i = 0; $i < 5; $i++) {
                yield $i;
            }
        });
        $this->assertInstanceOf(LazyCollection::class, $this->collection);
    }

    public function testImplementsCountable()
    {
        $this->assertInstanceOf('Countable', $this->collection);
    }

    public function testCanCountCorrectly()
    {
        $this->assertSame(5, $this->collection->count());
    }

    public function testCanConvertToJson()
    {
        $this->assertSame(json_encode([0, 1, 2, 3, 4]), $this->collection->toJson());
    }

    public function testCanConvertToArray()
    {
        $this->assertSame([0, 1, 2, 3, 4], $this->collection->toArray());
    }

    public function testImplementsMap()
    {
        $this->assertSame([0, 1, 8, 27, 64], $this->collection->map(function ($item) {
            return ($item * $item * $item);
        })->toArray());
    }

    public function testImplementsFilter()
    {
        $this->assertSame([0, 1, 2], $this->collection->filter(function ($item) {
            return $item < 3;
        })->toArray());
    }

    public function testImplementsReject()
    {
        $this->assertSame([0, 1, 2], $this->collection->reject(function ($item) {
            return $item >= 3;
        })->toArray());
    }

    public function testImplementsReduce()
    {
        $this->assertSame(10, $this->collection->reduce(function ($total, $item) {
            return $total += $item;
        }));
    }
}
