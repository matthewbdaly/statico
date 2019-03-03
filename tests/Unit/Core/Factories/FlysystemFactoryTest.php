<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Factories;

use Tests\TestCase;
use Statico\Core\Factories\FlysystemFactory;

class FlysystemFactoryTest extends TestCase
{
    public function testLocal()
    {
        $factory = new FlysystemFactory;
        $adapter = $factory->make([
            'path' => 'content/'
        ]);
        $this->assertInstanceOf('League\Flysystem\Adapter\Local', $adapter);
    }
}
