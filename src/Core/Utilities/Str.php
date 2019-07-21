<?php declare(strict_types = 1);

namespace Statico\Core\Utilities;

use Countable;
use ArrayAccess;
use SeekableIterator;
use Statico\Core\Contracts\Utilities\Stringable;
use Statico\Core\Utilities\Traits\Macroable;
use OutOfBoundsException;

/**
 * String class
 */
class Str implements Countable, ArrayAccess, SeekableIterator, Stringable
{
    use Macroable;

    /**
     * String
     *
     * @var string
     */
    protected $string;

    /**
     * Position
     *
     * @var integer
     */
    protected $position = 0;

    /**
     * Constructor
     *
     * @param string $string String to use.
     * @return void
     */
    public function __construct(string $string = '')
    {
        $this->string = $string;
    }

    /**
     * Create string
     *
     * @param string $string String to use.
     * @return Str
     */
    public static function make(string $string): Str
    {
        return new static($string);
    }

    /**
     * Return count of characters
     *
     * @return integer
     */
    public function count(): int
    {
        return strlen($this->string);
    }

    /**
     * Does item exist?
     *
     * @param mixed $offset The offset.
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->string[$offset]);
    }

    /**
     * Get offset
     *
     * @param mixed $offset The offset.
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->string[$offset]) ? $this->string[$offset] : null;
    }

    /**
     * Set offset
     *
     * @param mixed $offset The offset.
     * @param mixed $value  The value to set.
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->string .= $value;
            return;
        }
        $this->string[$offset] = $value;
    }

    /**
     * Unset offset
     *
     * @param mixed $offset The offset.
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->string = substr_replace($this->string, '', $offset, 1);
    }

    /**
     * Get current item
     *
     * @return mixed
     */
    public function current()
    {
        return $this->string[$this->position];
    }

    /**
     * Get key for current item
     *
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Move counter to next item
     *
     * @return void
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Move counter back to zero
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Is current item valid?
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return isset($this->string[$this->position]);
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Find and replace text
     *
     * @param string $find    Text to find.
     * @param string $replace Text to replace.
     * @return Str
     */
    public function replace(string $find, string $replace): Str
    {
        return new static(str_replace($find, $replace, $this->string));
    }

    /**
     * Convert to upper case
     *
     * @return Str
     */
    public function toUpper(): Str
    {
        return new static(strtoupper($this->string));
    }

    /**
     * Convert to lower case
     *
     * @return Str
     */
    public function toLower(): Str
    {
        return new static(strtolower($this->string));
    }

    /**
     * Trim whitespace
     *
     * @return Str
     */
    public function trim(): Str
    {
        return new static(trim($this->string));
    }

    /**
     * Trim left whitespace
     *
     * @return Str
     */
    public function ltrim(): Str
    {
        return new static(ltrim($this->string));
    }

    /**
     * Trim right whitespace
     *
     * @return Str
     */
    public function rtrim(): Str
    {
        return new static(rtrim($this->string));
    }

    /**
     * Seek a position
     *
     * @param mixed $position Position to seek.
     *
     * @return void
     *
     * @throws OutOfBoundsException Invalid position.
     */
    public function seek($position)
    {
        if (! isset($this->string[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }
        $this->position = $position;
    }

    /**
     * Handle path in a platform-independent way
     *
     * @return Str
     */
    public function path(): Str
    {
        return new static(preg_replace('/(\\\|\/)/', DIRECTORY_SEPARATOR, $this->string));
    }
}
