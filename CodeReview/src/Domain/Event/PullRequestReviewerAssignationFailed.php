<?php

declare(strict_types=1);

namespace CodeReview\Domain\Event;

use Common\Domain\Event\DomainEvent;

class PullRequestReviewerAssignationFailed implements DomainEvent
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $reviewer;

    /**
     * @var string
     */
    private $reason;

    public function __construct(string $id, string $reviewer, string $reason)
    {
        $this->id         = $id;
        $this->reviewer   = $reviewer;
        $this->reason     = $reason;
    }

    public function streamId(): string
    {
        return $this->id;
    }
}
