<?php

namespace Matthewbdaly\Proper\Contracts;

use Matthewbdaly\Proper\Contracts\Stringable;

interface Stringable
{
    /**
     * Create string
     *
     * @param string $string String to use.
     * @return Stringable
     */
    public static function make(string $string): Stringable;

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
     * @return Stringable
     */
    public function replace(string $find, string $replace): Stringable;

    /**
     * Convert to upper case
     *
     * @return Stringable
     */
    public function toUpper(): Stringable;

    /**
     * Convert to lower case
     *
     * @return Stringable
     */
    public function toLower(): Stringable;

    /**
     * Trim whitespace
     *
     * @return Stringable
     */
    public function trim(): Stringable;

    /**
     * Trim left whitespace
     *
     * @return Stringable
     */
    public function ltrim(): Stringable;

    /**
     * Trim right whitespace
     *
     * @return Stringable
     */
    public function rtrim(): Stringable;
}
