<?php

declare(strict_types=1);

namespace CodeReview\Application\Command;

use CodeReview\Domain\PullRequest;
use CodeReview\Domain\PullRequestRepository;
use Common\Application\Command\Command;
use Common\Application\Command\CommandHandler;

class CreatePullRequestCommandHandler implements CommandHandler
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
     * @param CreatePullRequestCommand $command
     */
    public function handle(Command $command): void
    {
        $events = PullRequest::create($this->repository, $command);

        $this->repository->saveEventStream($events);
    }
}
