<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Zend\Config\Config;

final class LoggerFactory
{
    public function make(Config $config): LoggerInterface
    {
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler('./logs/site.log', Logger::WARNING));
        return $log;
    }
}
