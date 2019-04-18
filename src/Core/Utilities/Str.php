<?php declare(strict_types = 1);

namespace Statico\Core\Utilities;

use Countable;
use ArrayAccess;
use SeekableIterator;
use Statico\Core\Contracts\Utilities\Stringable;
use Statico\Core\Utilities\Traits\IsString;
use Statico\Core\Utilities\Traits\IsMacroable;

/**
 * String class
 */
class Str implements Countable, ArrayAccess, SeekableIterator, Stringable
{
    use IsMacroable, IsString;

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
    public static function make(string $string): Stringable
    {
        return new static($string);
    }
}
