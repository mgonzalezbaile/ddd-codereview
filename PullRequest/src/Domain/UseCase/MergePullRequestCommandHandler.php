<?php

declare(strict_types=1);

namespace PullRequest\Domain\UseCase;

use Soa\EventSourcing\Command\Command;
use Soa\EventSourcing\Command\CommandHandler;
use Soa\EventSourcing\Event\EventStream;
use Soa\EventSourcing\Repository\AggregateRoot;
use PullRequest\Domain\Event\MergePullRequestFailed;
use PullRequest\Domain\Event\PullRequestMerged;
use PullRequest\Domain\PullRequest;

class MergePullRequestCommandHandler implements CommandHandler
{
    /**
     * @param MergePullRequestCommand $command
     * @param PullRequest             $pullRequest
     */
    public function handle(Command $command, AggregateRoot $pullRequest): EventStream
    {
        if (!$pullRequest->mergeable()) {
            return EventStream::fromDomainEvents(new MergePullRequestFailed($command->aggregateRootId(), MergePullRequestFailed::NOT_MERGEABLE));
        }

        if ($pullRequest->merged()) {
            return EventStream::fromDomainEvents(new MergePullRequestFailed($command->aggregateRootId(), MergePullRequestFailed::ALREADY_MERGED));
        }

        return EventStream::fromDomainEvents(new PullRequestMerged($command->aggregateRootId()));
    }
}
