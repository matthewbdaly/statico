<?php declare(strict_types = 1);

namespace Statico\Core\Factories;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

final class LoggerFactory
{
    public function make(array $config): LoggerInterface
    {
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler('./logs/site.log', Logger::WARNING));
        return $log;
    }
}
