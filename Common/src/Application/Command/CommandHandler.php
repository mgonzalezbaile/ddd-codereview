<?php

declare(strict_types=1);

namespace Common\Application\Command;

interface CommandHandler
{
    public function handle(Command $command): void;
}
