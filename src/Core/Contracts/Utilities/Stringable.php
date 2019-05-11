<?php

namespace Statico\Core\Contracts\Utilities;

use Statico\Core\Utilities\Str;

interface Stringable
{
    /**
     * Create string
     *
     * @param string $string String to use.
     * @return Str
     */
    public static function make(string $string): Str;

    /**
     * Return count of characters
     *
     * @return integer
     */
    public function count(): int;

    /**
     * Does item exist?
     *
     * @param mixed $offset The offset.
     * @return boolean
     */
    public function offsetExists($offset): bool;

    /**
     * Get offset
     *
     * @param mixed $offset The offset.
     * @return mixed
     */
    public function offsetGet($offset);

    /**
     * Set offset
     *
     * @param mixed $offset The offset.
     * @param mixed $value  The value to set.
     * @return void
     */
    public function offsetSet($offset, $value);

    /**
     * Unset offset
     *
     * @param mixed $offset The offset.
     * @return void
     */
    public function offsetUnset($offset);

    /**
     * Get current item
     *
     * @return mixed
     */
    public function current();

    /**
     * Get key for current item
     *
     * @return mixed
     */
    public function key();

    /**
     * Move counter to next item
     *
     * @return void
     */
    public function next();

    /**
     * Move counter back to zero
     *
     * @return void
     */
    public function rewind();

    /**
     * Is current item valid?
     *
     * @return boolean
     */
    public function valid(): bool;

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Find and replace text
     *
     * @param string $find    Text to find.
     * @param string $replace Text to replace.
     * @return Str
     */
    public function replace(string $find, string $replace): Str;

    /**
     * Convert to upper case
     *
     * @return Str
     */
    public function toUpper(): Str;

    /**
     * Convert to lower case
     *
     * @return Str
     */
    public function toLower(): Str;

    /**
     * Trim whitespace
     *
     * @return Str
     */
    public function trim(): Str;

    /**
     * Trim left whitespace
     *
     * @return Str
     */
    public function ltrim(): Str;

    /**
     * Trim right whitespace
     *
     * @return Str
     */
    public function rtrim(): Str;
}
