<?php declare(strict_types=1);

namespace Statico\Core\Utilities\Traits;

use Statico\Core\Contracts\Utilities\Stringable;
use OutOfBoundsException;

/**
 * String trait
 */
trait IsString
{
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
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->string .= $value;
        } else {
            $this->string[$offset] = $value;
        }
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
     * @return Stringable
     */
    public function replace(string $find, string $replace): Stringable
    {
        return new static(str_replace($find, $replace, $this->string));
    }

    /**
     * Convert to upper case
     *
     * @return Stringable
     */
    public function toUpper(): Stringable
    {
        return new static(strtoupper($this->string));
    }

    /**
     * Convert to lower case
     *
     * @return Stringable
     */
    public function toLower(): Stringable
    {
        return new static(strtolower($this->string));
    }

    /**
     * Trim whitespace
     *
     * @return Stringable
     */
    public function trim(): Stringable
    {
        return new static(trim($this->string));
    }

    /**
     * Trim left whitespace
     *
     * @return Stringable
     */
    public function ltrim(): Stringable
    {
        return new static(ltrim($this->string));
    }

    /**
     * Trim right whitespace
     *
     * @return Stringable
     */
    public function rtrim(): Stringable
    {
        return new static(rtrim($this->string));
    }

    /**
     * Seek a position
     *
     * @param mixed $position Position to seek.
     * @return Stringable
     * @throws OutOfBoundsException Invalid position.
     */
    public function seek($position)
    {
        if (! isset($this->string[$position])) {
            throw new OutOfBoundsException("invalid seek position ($position)");
        }
        $this->position = $position;
        return $this;
    }
}
