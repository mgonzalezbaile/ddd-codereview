<?php

declare(strict_types=1);

namespace Common\Application\Command;

interface CommandMiddleware
{
    public function __invoke(Command $command, callable $nextMiddleware): void;
}
