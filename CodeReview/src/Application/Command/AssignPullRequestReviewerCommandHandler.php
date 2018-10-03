<?php

declare(strict_types=1);

namespace CodeReview\Application\Command;

use CodeReview\Domain\PullRequest;
use CodeReview\Domain\PullRequestRepository;
use Common\Application\Command\Command;
use Common\Application\Command\CommandHandler;

class AssignPullRequestReviewerCommandHandler implements CommandHandler
{
    /**
     * @var PullRequestRepository
     */
    private $repository;

    public function __construct(PullRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AssignPullRequestReviewerCommand $command
     */
    public function handle(Command $command): void
    {
        $events = PullRequest::assignReviewer($this->repository->findOfId($command->pullRequestId()), $command);

        $this->repository->saveEventStream($events);
    }
}
