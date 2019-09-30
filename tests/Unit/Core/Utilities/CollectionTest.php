<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Utilities;

use Statico\Core\Utilities\Collection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use ReflectionClass;

final class CollectionTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var \Statico\Core\Utilities\Collection
     */
    private $collection;

    protected function setUp()
    {
        $items = [];
        $this->collection = new Collection($items);
    }

    protected function tearDown()
    {
        $this->collection = null;
        $reflect = new ReflectionClass(Collection::class);
        $macros = $reflect->getProperty('macros');
        $macros->setAccessible(true);
        $macros->setValue(null);
    }

    public function testCanBeCalledStatically()
    {
        $items = [
            'foo' => 'bar'
        ];
        $this->collection = Collection::make($items);
        $this->assertSame(1, $this->collection->count());
    }

    public function testImplementsCountable()
    {
        $this->assertInstanceOf('Countable', $this->collection);
    }

    public function testCanCountCorrectly()
    {
        $items = [
            'foo' => 'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(1, $this->collection->count());
    }

    public function testImplementsArrayAccess()
    {
        $this->assertInstanceOf('ArrayAccess', $this->collection);
    }

    public function testCanConfirmOffsetExists()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertTrue($this->collection->offsetExists(0));
    }

    public function testCanGetOffset()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame('foo', $this->collection->offsetGet(0));
    }

    public function testCanSetOffset()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->collection->offsetSet(0, 'baz');
        $this->assertSame(['baz', 'bar'], $this->collection->toArray());
        $this->assertSame('baz', $this->collection->offsetGet(0));
    }

    public function testAppendsElementWhenOffsetSetPassedNull()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->collection->offsetSet(null, 'baz');
        $this->assertSame(['foo', 'bar', 'baz'], $this->collection->toArray());
        $this->assertSame('foo', $this->collection->offsetGet(0));
        $this->assertSame('bar', $this->collection->offsetGet(1));
        $this->assertSame('baz', $this->collection->offsetGet(2));
    }

    public function testCanUnsetOffset()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->collection->offsetUnset(1);
        $this->assertSame(['foo'], $this->collection->toArray());
        $this->assertSame(null, $this->collection->offsetGet(1));
        $this->assertSame(1, $this->collection->count());
    }

    public function testImplementsTraversable()
    {
        $this->assertInstanceOf('Traversable', $this->collection);
    }

    public function testImplementsIterator()
    {
        $this->assertInstanceOf('Iterator', $this->collection);
    }

    public function testCanGetCurrentPosition()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame('foo', $this->collection->current());
    }

    public function testCanGetKey()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(0, $this->collection->key());
    }

    public function testCanMoveForward()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(0, $this->collection->key());
        $this->collection->next();
        $this->assertSame(1, $this->collection->key());
    }

    public function testCanRewind()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->collection->next();
        $this->assertSame(1, $this->collection->key());
        $this->collection->rewind();
        $this->assertSame(0, $this->collection->key());
    }

    public function testCanValidate()
    {
        $this->assertFalse($this->collection->valid());
    }

    public function testImplementsJsonSerializable()
    {
        $this->assertInstanceOf('JsonSerializable', $this->collection);
    }

    public function testCanJsonSerialize()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(json_encode($items), $this->collection->jsonSerialize());
    }

    public function testImplementsCollectable()
    {
        $this->assertInstanceOf('Statico\Core\Contracts\Utilities\Collectable', $this->collection);
    }

    public function testCanConvertToJson()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(json_encode($items), $this->collection->toJson());
    }

    public function testCanConvertToArray()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame($items, $this->collection->toArray());
    }

    public function testImplementsMap()
    {
        $items = [
            1,
            2,
            3
        ];
        $this->collection = new Collection($items);
        $this->assertSame([1,8,27], $this->collection->map(function ($item) {
            return ($item * $item * $item);
        })->toArray());
    }

    public function testImplementsFilter()
    {
        $items = [
            'foo' => 1,
            'bar' => 2,
            'baz' => 3
        ];
        $this->collection = new Collection($items);
        $this->assertSame([
            'bar' => 2,
            'baz' => 3
        ], $this->collection->filter(function ($v) {
            return $v > 1;
        })->toArray());
    }

    public function testImplementsReject()
    {
        $items = [
            'foo' => 1,
            'bar' => 2,
            'baz' => 3
        ];
        $this->collection = new Collection($items);
        $this->assertSame([
            'bar' => 2,
            'baz' => 3
        ], $this->collection->reject(function ($v) {
            return $v <= 1;
        })->toArray());
    }

    public function testImplementsReduce()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(6, $this->collection->reduce(function ($total, $item) {
            return $total += $item;
        }));
    }

    public function testImplementsPluck()
    {
        $items = [[
            'foo' => 1,
            'bar' => 2
        ], [
            'foo' => 3,
            'bar' => 4
        ], [
            'foo' => 5,
            'bar' => 6
        ]];
        $this->collection = new Collection($items);
        $this->assertSame([1, 3, 5], $this->collection->pluck('foo')->toArray());
    }

    public function testImplementsEach()
    {
        /** @var DateTime|\PHPUnit\Framework\MockObject\MockObject $date */
        $date = m::mock('DateTime');
        $date->shouldReceive('setTimezone')
            ->with('Europe/London')
            ->once()
            ->andReturn(null);
        $this->collection = new Collection([$date]);
        $this->collection->each(function ($item) {
            $item->setTimezone('Europe/London');
        });
    }

    public function testImplementsPush()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3, 4], $this->collection->push(4)->toArray());
    }

    public function testImplementsPop()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(3, $this->collection->pop());
        $this->assertSame([1, 2], $this->collection->toArray());
    }

    public function testImplementsUnshift()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame([4, 1, 2, 3], $this->collection->unshift(4)->toArray());
    }

    public function testImplementsShift()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(1, $this->collection->shift());
        $this->assertSame([2, 3], $this->collection->toArray());
    }

    public function testImplementsSort()
    {
        $items = [2, 1, 3];
        $this->collection = new Collection($items);
        $this->assertSame([3, 2, 1], $this->collection->sort(function ($a, $b) {
            return ($a > $b) ? -1 : 1;
        })->toArray());
    }

    public function testAllowsACallbackToSort()
    {
        $items = [2, 1, 3];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->sort()->toArray());
    }

    public function testImplementsReverse()
    {
        $items = [3, 2, 1];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->reverse()->toArray());
    }

    public function testImplementsKeys()
    {
        $items = [
            1 => "a",
            2 => "b",
            3 => "c"
        ];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->keys()->toArray());
    }

    public function testImplementsValues()
    {
        $items = [
            1 => "a",
            2 => "b",
            3 => "c"
        ];
        $this->collection = new Collection($items);
        $this->assertSame(["a", "b", "c"], $this->collection->values()->toArray());
    }

    public function testImplementsChunk()
    {
        $items = [
            "a",
            "b",
            "c",
            "d",
            "e"
        ];
        $this->collection = new Collection($items);
        $this->assertSame([[
            "a",
            "b",
        ], [
            "c",
            "d",
        ], [
            "e"
        ]], $this->collection->chunk(2)->toArray());
    }

    public function testImplementsMerge()
    {
        $items = [
            "a",
            "b",
            "c",
            "d",
            "e"
        ];
        $merged = [
            "f",
            "g"
        ];
        $this->collection = new Collection($items);
        $this->assertSame([
            "a",
            "b",
            "c",
            "d",
            "e",
            "f",
            "g"
        ], $this->collection->merge($merged)->toArray());
    }

    public function testImplementsSeek()
    {
        $items = [
            "a",
            "b",
            "c",
            "d",
            "e"
        ];
        $this->collection = new Collection($items);
        $this->collection->seek(2);
        $this->assertSame("c", $this->collection->current());
    }

    public function testSeekOutOfBounds()
    {
        $this->expectException('OutOfBoundsException');
        $items = [
            "a",
            "b",
            "c",
            "d",
            "e"
        ];
        $this->collection = new Collection($items);
        $this->collection->seek(7);
    }

    public function testImplementsGroupBy()
    {
        $items = [
            ['account_id' => 'account-x10', 'product' => 'Chair'],
            ['account_id' => 'account-x10', 'product' => 'Bookcase'],
            ['account_id' => 'account-x11', 'product' => 'Desk'],
        ];
        $this->collection = new Collection($items);
        $this->assertSame([
            'account-x10' => [
                ['account_id' => 'account-x10', 'product' => 'Chair'],
                ['account_id' => 'account-x10', 'product' => 'Bookcase'],
            ],
            'account-x11' => [
                ['account_id' => 'account-x11', 'product' => 'Desk'],
            ],
        ], $this->collection->groupBy('account_id')->toArray());
    }

    public function testImplementsFlatten()
    {
        $items = [
            1,
            2,
            3,
            [4, 5],
            [6, 7, 8],
            9
        ];
        $this->collection = new Collection($items);
        $this->assertSame([
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9
        ], $this->collection->flatten()->toArray());
    }

    public function testSupportsMacros()
    {
        $items = [16, 25];
        $collection = new Collection($items);
        $collection->macro('squareRoot', function () use ($collection) {
            return $collection->map(function ($number) {
                return (int)sqrt($number);
            });
        });
        $this->assertSame([4, 5], $collection->squareRoot()->toArray());
    }

    public function testSupportsStaticMacros()
    {
        $items = [16, 25];
        $collection = new Collection($items);
        Collection::macro('squareRoot', function () use ($collection) {
            return $collection->map(function ($number) {
                return (int)sqrt($number);
            });
        });
        $this->assertSame([4, 5], $collection->squareRoot()->toArray());
    }

    public function testSupportsCallingMacrosStatically()
    {
        Collection::macro('bananas', function () {
            return 'bananas';
        });
        $this->assertSame('bananas', Collection::bananas());
    }

    public function testAbsentMacroMethod()
    {
        $this->expectException('BadMethodCallException');
        $items = [16, 25];
        $collection = new Collection($items);
        $collection->foo();
    }

    public function testAbsentMacroMethodStatic()
    {
        $this->expectException('BadMethodCallException');
        Collection::foo();
    }

    public function testMixinFromClass()
    {
        Collection::mixin(new class {
            public function foo()
            {
                return 'Foo';
            }
        });
        $items = [16, 25];
        $collection = new Collection($items);
        $this->assertEquals('Foo', $collection->foo());
    }

    public function testCallMacroStatically()
    {
        Collection::mixin(new class {
            public function foo()
            {
                return 'Foo';
            }
        });
        $items = [16, 25];
        $collection = new Collection($items);
        $this->assertEquals('Foo', Collection::foo());
    }

    public function testCallCallableMacro()
    {
        $callable = new class {
            public function __invoke()
            {
                return 'Foo';
            }
        };
        $items = [16, 25];
        Collection::macro('foo', $callable);
        $collection = new Collection($items);
        $this->assertEquals('Foo', $collection->foo());
    }

    public function testCallCallableMacroStatically()
    {
        $callable = new class {
            public function __invoke()
            {
                return 'Foo';
            }
        };
        $items = [16, 25];
        Collection::macro('foo', $callable);
        $this->assertEquals('Foo', Collection::foo());
    }

    public function testPaginate()
    {
        $items = [1, 2, 3, 4, 5];
        $collection = new Collection($items);
        $this->assertEquals([1, 2, 3], $collection->paginate(3, 1)->toArray());
        $this->assertEquals([4, 5], $collection->paginate(3, 2)->toArray());
    }

    public function testImplementsSerializable()
    {
        $this->assertInstanceOf('Serializable', $this->collection);
    }

    public function testSerializeAndUnserialize()
    {
        $items = [1, 2, 3, 4, 5];
        $collection = new Collection($items);
        $data = $collection->serialize();
        $this->assertEquals(serialize($items), $data);
        $newCollection = new Collection([]);
        $newCollection->unserialize($data);
        $this->assertEquals($collection, $newCollection);
    }
}
