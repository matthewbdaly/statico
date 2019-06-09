<?php declare(strict_types = 1);

namespace Tests\Unit\Utilities;

use Statico\Core\Utilities\Str;

final class StrTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Statico\Core\Utilities\Str
     */
    private $str;

    protected function setUp()
    {
        $str = 'I am the very model of a modern major general';
        $this->str = new Str($str);
    }

    function testImplementsCountable()
    {
        $this->assertInstanceOf('Countable', $this->str);
    }

    function testCanCountCorrectly()
    {
        $this->assertSame(45, $this->str->count());
    }

    function testCanBeCalledStatically()
    {
        $str = 'I am the very model of a modern major general';
        $this->str = Str::make($str);
        $this->assertSame(45, $this->str->count());
    }

    function testImplementsArrayAccess()
    {
        $this->assertInstanceOf('ArrayAccess', $this->str);
    }

    function testCanConfirmOffsetExists()
    {
        $this->assertTrue($this->str->offsetExists(0));
    }

    function testCanGetOffset()
    {
        $this->assertSame('I', $this->str->offsetGet(0));
    }

    function testCanSetOffset()
    {
        $this->str->offsetSet(0, 'A');
        $this->assertSame('A', $this->str->offsetGet(0));
    }

    function testAppendsElementWhenOffsetSetPassedNull()
    {
        $this->str->offsetSet(null, 'B');
        $this->assertSame('I', $this->str->offsetGet(0));
        $this->assertSame('B', $this->str->offsetGet(45));
    }

    function testCanUnsetOffset()
    {
        $this->str->offsetUnset(1);
        $this->assertSame('a', $this->str->offsetGet(1));
        $this->assertSame(44, $this->str->count());
    }

    function testImplementsTraversable()
    {
        $this->assertInstanceOf('Traversable', $this->str);
    }

    function testImplementsIterator()
    {
        $this->assertInstanceOf('Iterator', $this->str);
    }

    function testCanGetCurrentPosition()
    {
        $this->assertSame('I', $this->str->current());
    }

    function testCanGetKey()
    {
        $this->assertSame(0, $this->str->key());
    }

    function testCanMoveForward()
    {
        $this->assertSame(0, $this->str->key());
        $this->str->next();
        $this->assertSame(1, $this->str->key());
    }

    function testCanRewind()
    {
        $this->str->next();
        $this->assertSame(1, $this->str->key());
        $this->str->rewind();
        $this->assertSame(0, $this->str->key());
    }

    function testCanValidate()
    {
        $this->assertTrue($this->str->valid());
    }

    function testRendersToString()
    {
        $this->assertSame('I am the very model of a modern major general', $this->str->__toString());
    }

    function testCanReplace()
    {
        $this->assertSame('I am the very model of a scientist Salarian', $this->str->replace('modern major general', 'scientist Salarian')->__toString());
    }

    function testCanConvertToUpper()
    {
        $this->assertSame('I AM THE VERY MODEL OF A MODERN MAJOR GENERAL', $this->str->toUpper()->__toString());
    }

    function testCanConvertToLower()
    {
        $this->assertSame('i am the very model of a modern major general', $this->str->toLower()->__toString());
    }

    function testCanTrim()
    {
        $str = '  I am the very model of a modern major general  ';
        $this->str = new Str($str);
        $this->assertSame('I am the very model of a modern major general', $this->str->trim()->__toString());
    }

    function testCanLtrim()
    {
        $str = '  I am the very model of a modern major general  ';
        $this->str = new Str($str);
        $this->assertSame('I am the very model of a modern major general  ', $this->str->ltrim()->__toString());
    }

    function testCanRtrim()
    {
        $str = '  I am the very model of a modern major general  ';
        $this->str = new Str($str);
        $this->assertSame('  I am the very model of a modern major general', $this->str->rtrim()->__toString());
    }

    function testImplementsSeek()
    {
        $str = 'I am the very model of a modern major general  ';
        $this->str = new Str($str);
        $this->str->seek(2);
        $this->assertSame("a", $this->str->current());
    }

    function testSupportsMacros()
    {
        $this->str->macro('bananas', function () {
            return 'bananas';
        });
        $this->assertSame('bananas', $this->str->bananas());
    }

    function testSupportsStaticMacros()
    {
        Str::macro('bananas', function () {
            return 'bananas';
        });
        $str = 'I am the very model of a modern major general  ';
        $this->str = new Str($str);
        $this->assertSame('bananas', $this->str->bananas());
    }

    function testPath()
    {
        $str = new Str('\foo\bar');
        $this->assertSame(DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'bar', $str->path()->__toString());
    }
}
