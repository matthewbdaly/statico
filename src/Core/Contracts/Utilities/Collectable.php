<?php

declare(strict_types=1);

namespace Statico\Core\Contracts\Utilities;

use Closure;
use OutOfBoundsException;

interface Collectable
{
    /**
     * Convert collection to J)SON
     *
     * @return string|false
     */
    public function toJson();

    /**
     * Convert collection to array
     *
     * @return array
     */
    public function toArray();

    /**
     * Map operation
     *
     * @param Closure $callback The callback to use.
     * @return Collectable
     */
    public function map(Closure $callback);

    /**
     * Filter operation
     *
     * @param Closure $callback The callback to use.
     * @return Collectable
     */
    public function filter(Closure $callback);

    /**
     * Reverse filter operation
     *
     * @param Closure $callback The callback to use.
     * @return Collectable
     */
    public function reject(Closure $callback);

    /**
     * Reduce operation
     *
     * @param Closure $callback The callback to use.
     * @param mixed   $initial  The initial value.
     * @return mixed
     */
    public function reduce(Closure $callback, $initial = 0);

    /**
     * Pluck a single field
     *
     * @param mixed $name Name of field to pluck.
     * @return mixed
     */
    public function pluck($name);

    /**
     * Apply callback to each item in the collection
     *
     * @param Closure $callback The callback to use.
     * @return void
     */
    public function each(Closure $callback);
}
