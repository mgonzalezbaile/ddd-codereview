<?php

declare(strict_types=1);

namespace CodeReview\Application\Command;

use Common\Application\Command\Command;

class AssignPullRequestReviewerCommand implements Command
{
    /**
     * @var string
     */
    private $pullRequestId;

    /**
     * @var string
     */
    private $reviewer;

    public function __construct(string $pullRequestId, string $reviewer)
    {
        $this->pullRequestId   = $pullRequestId;
        $this->reviewer        = $reviewer;
    }

    public function pullRequestId(): string
    {
        return $this->pullRequestId;
    }

    public function reviewer(): string
    {
        return $this->reviewer;
    }
}
