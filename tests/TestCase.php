<?php declare(strict_types = 1);

namespace Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Statico\Core\Kernel;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp(): void
    {
        if (!defined('BASE_DIR')) {
            define('BASE_DIR', __DIR__.'/../');
        }
        if (!defined('CONTENT_PATH')) {
            define('CONTENT_PATH', 'content/');
        }
        $this->app = new Kernel;
        $this->app->bootstrap();
        $this->container = $this->app->getContainer();
    }

    public function tearDown(): void
    {
        $this->app = null;
        $this->container = null;
    }
}