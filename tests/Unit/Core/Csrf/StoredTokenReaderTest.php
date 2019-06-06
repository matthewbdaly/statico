<?php declare(strict_types=1);

namespace Tests\Unit\Core\Csrf;

use Tests\TestCase;
use Statico\Core\Csrf\StoredTokenReader;
use Statico\Core\Csrf\Token;
use Mockery as m;

final class StoredTokenReaderTest extends TestCase
{
    public function testReadToken()
    {
        $storage = m::mock('Statico\Core\Csrf\TokenStorage');
        $token = new Token('bar');
        $storage->shouldReceive('retrieve')
            ->with('foo')
            ->once()
            ->andReturn($token);
        $reader = new StoredTokenReader($storage);
        $this->assertEquals($token, $reader->read('foo'));
    }

    public function testGenerateToken()
    {
        $storage = m::mock('Statico\Core\Csrf\TokenStorage');
        $storage->shouldReceive('retrieve')
            ->with('foo')
            ->once()
            ->andReturn(null);
        $storage->shouldReceive('store')->once();
        $reader = new StoredTokenReader($storage);
        $this->assertInstanceOf(Token::class, $reader->read('foo'));
    }
}
