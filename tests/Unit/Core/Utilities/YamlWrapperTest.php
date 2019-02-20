<?php declare(strict_types = 1);

namespace Tests\Unit\Utilities;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Utilities\YamlWrapper;
use Symfony\Component\Yaml\Yaml;

class YamlWrapperTest extends TestCase
{
    public function testParse()
    {
        $originalContent = [
            'foo' => 'bar'
        ];
        $parser = m::mock('Symfony\Component\Yaml\Yaml');
        $parser->shouldReceive('parse')->with('file')
            ->andReturn($originalContent);
        $wrapper = new YamlWrapper($parser);
        $this->assertEquals($originalContent, $wrapper->__invoke('file'));
    }
}
