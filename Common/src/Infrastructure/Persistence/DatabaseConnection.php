<?php

declare(strict_types=1);

namespace Common\Infrastructure\Persistence;

interface DatabaseConnection
{
    public function beginTransaction(): void;

    public function commitTransaction(): void;

    public function rollbackTransaction(): void;
}
