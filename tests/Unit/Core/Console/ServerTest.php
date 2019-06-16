<?php declare(strict_types = 1);

namespace Tests\Unit\Core\Console;

use Tests\TestCase;
use Mockery as m;
use Symfony\Component\Console\Tester\CommandTester;
use Statico\Core\Console\Server;
use phpmock\mockery\PHPMockery;

final class ServerTest extends TestCase
{
    public function testExecute()
    {
        $passthru = PHPMockery::mock('Statico\Core\Console', "passthru");
        $cmd = new Server;
        $tester = new CommandTester($cmd);
        $tester->execute([]);
    }
}
