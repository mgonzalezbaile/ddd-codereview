<?php

declare(strict_types=1);

namespace Common\Application\Command\Middleware;

use Common\Application\Command\Command;
use Common\Application\Command\CommandMiddleware;
use Common\Infrastructure\Persistence\DatabaseConnection;

class TransactionMiddleware implements CommandMiddleware
{
    /**
     * @var DatabaseConnection
     */
    private $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke(Command $command, callable $nextMiddleware): void
    {
        try {
            $this->connection->beginTransaction();

            $nextMiddleware($command);

            $this->connection->commitTransaction();
        } catch (\Throwable $exception) {
            $this->connection->rollbackTransaction();

            throw $exception;
        }
    }
}
