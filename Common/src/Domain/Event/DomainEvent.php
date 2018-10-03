<?php

declare(strict_types=1);

namespace Common\Domain\Event;

interface DomainEvent
{
    public function streamId(): string;
}
