<?php

declare(strict_types=1);

namespace CodeReview\Domain\Event;

use Common\Domain\Event\DomainEvent;

class PullRequestCreationFailed implements DomainEvent
{
    /**
     * @var string
     */
    private $writer;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $reason;

    public function __construct(string $writer, string $code, string $reason)
    {
        $this->writer = $writer;
        $this->code   = $code;
        $this->reason = $reason;
    }

    public function streamId(): string
    {
        return 'n/a';
    }
}
