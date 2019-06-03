<?php declare(strict_types=1);

namespace Tests\Unit\Core\Csrf;

use Tests\TestCase;
use Statico\Core\Csrf\SymfonySessionTokenStorage;
use Statico\Core\Csrf\Token;
use Mockery as m;

class SymfonySessionTokenStorageTest extends TestCase
{
    public function testCreate()
    {
        $session = m::mock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $storage = new SymfonySessionTokenStorage($session);
        $token = new Token('bar');
        $session->shouldReceive('get')->once()->andReturn(null);
        $session->shouldReceive('set')->with('foo', 'bar')->once()->andReturn(null);
        $this->assertNull($storage->retrieve('foo'));
        $storage->store('foo', $token);
        $session->shouldReceive('get')->once()->andReturn('bar');
        $this->assertEquals($token, $storage->retrieve('foo'));
    }
}
