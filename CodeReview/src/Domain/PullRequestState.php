<?php

declare(strict_types=1);

namespace CodeReview\Domain;

class PullRequestState
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $reviewers;

    public function __construct(string $id, array $reviewers = [])
    {
        $this->id        = $id;
        $this->reviewers = $reviewers;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function reviewers(): array
    {
        return $this->reviewers;
    }
}
