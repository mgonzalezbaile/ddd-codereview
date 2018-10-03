<?php

declare(strict_types=1);

namespace CodeReview\Infrastructure\Persistence\InMemory;

use CodeReview\Domain\PullRequestRepository;
use CodeReview\Domain\PullRequestState;
use Common\Domain\Event\EventStream;
use Ramsey\Uuid\Uuid;

class InMemoryPullRequestRepository implements PullRequestRepository
{
    /**
     * @var PullRequestState[]
     */
    private $pullRequests;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var EventStream
     */
    private $eventStream;

    public static function withFixedId(string $id)
    {
        return new self($id);
    }

    public static function withRandomId()
    {
        return new self();
    }

    private function __construct(string $id = null)
    {
        $this->id = $id;
    }

    public function nextIdentity(): string
    {
        return $this->id ?? Uuid::uuid4()->toString();
    }

    public function save(PullRequestState $pullRequest): void
    {
        $this->pullRequests[$pullRequest->id()] = $pullRequest;
    }

    public function findOfId(string $id): PullRequestState
    {
        return $this->pullRequests[$id];
    }

    public function saveEventStream(EventStream $eventStream): void
    {
        $this->eventStream = $eventStream;
    }

    public function eventStream(): EventStream
    {
        return $this->eventStream;
    }
}
