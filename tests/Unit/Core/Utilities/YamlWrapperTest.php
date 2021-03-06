<?php

declare(strict_types=1);

namespace Statico\Tests\Unit\Core\Utilities;

use Statico\Tests\TestCase;
use Mockery as m;
use Statico\Core\Utilities\YamlWrapper;
use Symfony\Component\Yaml\Yaml;

final class YamlWrapperTest extends TestCase
{
    public function testParse()
    {
        $originalContent = ['foo' => 'bar'];
        $parser = m::mock('Symfony\Component\Yaml\Yaml');
        $parser->shouldReceive('parse')->with('file')
            ->andReturn($originalContent);
        $wrapper = new YamlWrapper($parser);
        $this->assertEquals($originalContent, $wrapper->__invoke('file'));
    }
}
