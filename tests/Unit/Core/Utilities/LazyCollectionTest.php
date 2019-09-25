<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Utilities;

use Statico\Core\Utilities\LazyCollection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

final class LazyCollectionTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCanBeCalledStatically()
    {
        $this->collection = LazyCollection::make(function () {
            for ($i = 0; $i < 5; $i++) {
                yield $i;
            }
        });
        $this->assertInstanceOf(LazyCollection::class, $this->collection);
    }
}
