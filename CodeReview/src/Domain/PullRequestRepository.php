<?php

declare(strict_types=1);

namespace CodeReview\Domain;

interface PullRequestRepository
{
    public function nextIdentity(): string;

    public function save(PullRequest $pullRequest): void;

    public function findOfId(string $id): PullRequest;
}
