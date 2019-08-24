<?php declare(strict_types=1);

namespace Statico\Core\Exceptions;

use Psr\Log\LoggerInterface;
use Throwable;
use Whoops\Exception\Inspector;
use Whoops\RunInterface;
use Statico\Core\Contracts\Exceptions\Handler;

final class LogHandler implements Handler
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Throwable $exception, Inspector $inspector, RunInterface $run): void
    {
        $this->logger->error($exception->getMessage(), $exception->getTrace());
    }
}
