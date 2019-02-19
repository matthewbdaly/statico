<?php declare(strict_types = 1);

namespace Statico\Core\Paths;

use Statico\Core\Contracts\Paths\Path;

final class LocalPath implements Path
{
    /**
     * @var string
     */
    protected $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function get()
    {
        return $this->path;
    }
}
