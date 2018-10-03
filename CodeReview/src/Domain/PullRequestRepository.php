<?php

declare(strict_types=1);

namespace CodeReview\Domain;

use Common\Domain\Event\EventStream;

interface PullRequestRepository
{
    public function nextIdentity(): string;

    public function saveEventStream(EventStream $eventStream): void;

    public function findOfId(string $id): PullRequestState;
}
