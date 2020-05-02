<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Console\Commands;

use Statico\Tests\TestCase;
use Mockery as m;
use Symfony\Component\Console\Tester\CommandTester;
use Statico\Core\Console\Commands\Server;
use phpmock\mockery\PHPMockery;

final class ServerTest extends TestCase
{
    public function testExecute()
    {
        $passthru = PHPMockery::mock('Statico\Core\Console\Commands', "passthru");
        $cmd = new Server();
        $tester = new CommandTester($cmd);
        $tester->execute([]);
        $this->assertEquals('server', $cmd->getName());
        $this->assertEquals('Runs the development server', $cmd->getDescription());
        $this->assertEquals('This command runs the development server', $cmd->getHelp());
    }
}
