<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FlysystemFactory;

class FlysystemFactoryTest extends TestCase
{
    public function testLocal()
    {
        $factory = FlysystemFactory::create([
            'path' => 'content/'
        ]);
        $this->assertInstanceOf('League\Flysystem\Adapter\Local', $factory);
    }
}
