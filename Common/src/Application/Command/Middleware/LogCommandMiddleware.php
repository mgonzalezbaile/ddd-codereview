<?php

declare(strict_types=1);

namespace Common\Application\Command\Middleware;

use Common\Application\Command\Command;
use Common\Application\Command\CommandMiddleware;
use Psr\Log\LoggerInterface;

class LogCommandMiddleware implements CommandMiddleware
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Command $command, callable $nextMiddleware): void
    {
        $this->logger->info($command);

        $nextMiddleware($command);
    }
}
