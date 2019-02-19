<?php declare(strict_types = 1);

namespace Tests\Unit;

use Tests\TestCase;
use Mockery as m;
use Statico\Core\Kernel;
use League\Container\Container;

class KernelTest extends TestCase
{
    public function setUp(): void
    {
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', __DIR__.'/../');
        }
        if (!defined('CONTENT_PATH')) {
            define('CONTENT_PATH', 'content/');
        }
    }

    public function testLoadPlugin()
    {
        $container = new Container;
        $mockConfig = m::mock('Zend\Config\Reader\ReaderInterface');
        $mockConfig->shouldReceive('fromFile')->andReturn([
            'plugins' => [
                'DateTime',
                'Statico\Plugins\Search\Main'
            ]
        ]);
        $container->share('Zend\Config\Reader\ReaderInterface', $mockConfig);
        $kernel = new Kernel($container);
        $kernel->bootstrap();
        $this->assertCount(1, ($kernel->getRegisteredPlugins()));
    }
}
