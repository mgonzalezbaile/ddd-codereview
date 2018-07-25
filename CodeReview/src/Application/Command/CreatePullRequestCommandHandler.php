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
        $pullRequest = new PullRequest($this->repository, $command->code(), $command->writer());

        $this->repository->save($pullRequest);
    }
}
