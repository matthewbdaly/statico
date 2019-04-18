<?php declare(strict_types = 1);

namespace Tests\Unit\Utilities;

use Statico\Core\Utilities\Collection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;

class CollectionTest extends \PHPUnit\Framework\TestCase
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

    function testCanBeCalledStatically()
    {
        $items = [
            'foo' => 'bar'
        ];
        $this->collection = Collection::make($items);
        $this->assertSame(1, $this->collection->count());
    }

    function testImplementsCountable()
    {
        $this->assertInstanceOf('Countable', $this->collection);
    }

    function testCanCountCorrectly()
    {
        $items = [
            'foo' => 'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(1, $this->collection->count());
    }

    function testImplementsArrayAccess()
    {
        $this->assertInstanceOf('ArrayAccess', $this->collection);
    }

    function testCanConfirmOffsetExists()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertTrue($this->collection->offsetExists(0));
    }

    function testCanGetOffset()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame('foo', $this->collection->offsetGet(0));
    }

    function testCanSetOffset()
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

    function testAppendsElementWhenOffsetSetPassedNull()
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

    function testCanUnsetOffset()
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

    function testImplementsTraversable()
    {
        $this->assertInstanceOf('Traversable', $this->collection);
    }

    function testImplementsIterator()
    {
        $this->assertInstanceOf('Iterator', $this->collection);
    }

    function testCanGetCurrentPosition()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame('foo', $this->collection->current());
    }

    function testCanGetKey()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(0, $this->collection->key());
    }

    function testCanMoveForward()
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

    function testCanRewind()
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

    function testCanValidate()
    {
        $this->assertFalse($this->collection->valid());
    }

    function testImplementsJsonSerializable()
    {
        $this->assertInstanceOf('JsonSerializable', $this->collection);
    }

    function testCanJsonSerialize()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(json_encode($items), $this->collection->jsonSerialize());
    }

    function testImplementsCollectable()
    {
        $this->assertInstanceOf('Statico\Core\Contracts\Utilities\Collectable', $this->collection);
    }

    function testCanConvertToJson()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame(json_encode($items), $this->collection->toJson());
    }

    function testCanConvertToArray()
    {
        $items = [
            'foo',
            'bar'
        ];
        $this->collection = new Collection($items);
        $this->assertSame($items, $this->collection->toArray());
    }

    function testImplementsMap()
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

    function testImplementsFilter()
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

    function testImplementsReject()
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

    function testImplementsReduce()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(6, $this->collection->reduce(function ($total, $item) {
            return $total += $item;
        }));
    }

    function testImplementsPluck()
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

    function testImplementsEach()
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

    function testImplementsPush()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3, 4], $this->collection->push(4)->toArray());
    }

    function testImplementsPop()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(3, $this->collection->pop());
        $this->assertSame([1, 2], $this->collection->toArray());
    }

    function testImplementsUnshift()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame([4, 1, 2, 3], $this->collection->unshift(4)->toArray());
    }

    function testImplementsShift()
    {
        $items = [1, 2, 3];
        $this->collection = new Collection($items);
        $this->assertSame(1, $this->collection->shift());
        $this->assertSame([2, 3], $this->collection->toArray());
    }

    function testImplementsSort()
    {
        $items = [2, 1, 3];
        $this->collection = new Collection($items);
        $this->assertSame([3, 2, 1], $this->collection->sort(function ($a, $b) {
            return ($a > $b) ? -1 : 1;
        })->toArray());
    }

    function testAllowsACallbackToSort()
    {
        $items = [2, 1, 3];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->sort()->toArray());
    }

    function testImplementsReverse()
    {
        $items = [3, 2, 1];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->reverse()->toArray());
    }

    function testImplementsKeys()
    {
        $items = [
            1 => "a",
            2 => "b",
            3 => "c"
        ];
        $this->collection = new Collection($items);
        $this->assertSame([1, 2, 3], $this->collection->keys()->toArray());
    }

    function testImplementsValues()
    {
        $items = [
            1 => "a",
            2 => "b",
            3 => "c"
        ];
        $this->collection = new Collection($items);
        $this->assertSame(["a", "b", "c"], $this->collection->values()->toArray());
    }

    function testImplementsChunk()
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

    function testImplementsMerge()
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

    function testImplementsSeek()
    {
        $items = [
            "a",
            "b",
            "c",
            "d",
            "e"
        ];
        $this->collection = new Collection($items);
        $this->assertSame("c", $this->collection->seek(2)->current());
    }

    function testImplementsGroupBy()
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

    function testImplementsFlatten()
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

    function testSupportsMacros()
    {
        $items = [16, 25];
        $collection = new Collection($items);
        $collection->macro('squareRoot', function () use ($collection) {
            return $collection->map(function($number) {
                return (int)sqrt($number);
            });
        });
        $this->assertSame([4, 5], $collection->squareRoot()->toArray());
    }

    function testSupportsStaticMacros()
    {
        $items = [16, 25];
        $collection = new Collection($items);
        Collection::macro('squareRoot', function () use ($collection) {
            return $collection->map(function($number) {
                return (int)sqrt($number);
            });
        });
        $this->assertSame([4, 5], $collection->squareRoot()->toArray());
    }
}
