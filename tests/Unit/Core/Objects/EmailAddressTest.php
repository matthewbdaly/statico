<?php declare(strict_types=1);

namespace Tests\Unit\Core\Objects;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Objects\EmailAddress;

final class EmailAddressTest extends TestCase
{
    public function testCreate()
    {
        $email = "bob@example.com";
        $obj = new EmailAddress($email);
        $this->assertEquals($email, $obj->__toString());
    }

    public function testFailedCreate()
    {
        $this->expectException('Statico\Core\Exceptions\Objects\EmailAddressInvalid');
        $email = "example.com";
        $obj = new EmailAddress($email);
    }

    public function testEquals()
    {
        $obj = new EmailAddress('bob@example.com');
        $this->assertTrue($obj->equals(new EmailAddress('bob@example.com')));
        $this->assertFalse($obj->equals(new EmailAddress('eric@example.com')));
    }
}
