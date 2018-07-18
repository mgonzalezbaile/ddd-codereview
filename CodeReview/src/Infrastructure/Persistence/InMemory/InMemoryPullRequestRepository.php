<?php

declare(strict_types=1);

namespace CodeReview\Infrastructure\Persistence\InMemory;

use CodeReview\Domain\PullRequest;
use CodeReview\Domain\PullRequestRepository;
use Ramsey\Uuid\Uuid;

class InMemoryPullRequestRepository implements PullRequestRepository
{
    /**
     * @var PullRequest[]
     */
    private $pullRequests;

    /**
     * @var string|null
     */
    private $id;

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

    public function save(PullRequest $pullRequest): void
    {
        $this->pullRequests[$pullRequest->id()] = $pullRequest;
    }

    public function findOfId(string $id): PullRequest
    {
        return $this->pullRequests[$id];
    }
}
