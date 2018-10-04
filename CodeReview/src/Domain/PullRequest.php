<?php

declare(strict_types=1);

namespace CodeReview\Domain;

use CodeReview\Application\Command\AssignPullRequestReviewerCommand;
use CodeReview\Application\Command\CreatePullRequestCommand;
use CodeReview\Domain\Event\PullRequestCreated;
use CodeReview\Domain\Event\PullRequestCreationFailed;
use CodeReview\Domain\Event\PullRequestReviewerAssigned;
use CodeReview\Domain\Event\PullRequestReviewerAssignationFailed;
use Common\Domain\Event\EventStream;

class PullRequest
{
    public static function create(PullRequestRepository $repository, CreatePullRequestCommand $command): EventStream
    {
        $id = $repository->nextIdentity();

        if (!$command->code()) {
            return EventStream::fromDomainEvents(new PullRequestCreationFailed($command->writer(), $command->code(), 'empty code'));
        }

        if (!$command->writer()) {
            return EventStream::fromDomainEvents(new PullRequestCreationFailed($command->writer(), $command->code(), 'empty writer'));
        }

        return EventStream::fromDomainEvents(new PullRequestCreated($id, $command->writer(), $command->code()));
    }

    public static function assignReviewer(PullRequestState $state, AssignPullRequestReviewerCommand $command): EventStream
    {
        if (!$command->reviewer()) {
            return EventStream::fromDomainEvents(new PullRequestReviewerAssignationFailed($command->pullRequestId(), $command->reviewer(), 'empty reviewer'));
        }

        if (in_array($command->reviewer(), $state->reviewers())) {
            return EventStream::fromDomainEvents(new PullRequestReviewerAssignationFailed($command->pullRequestId(), $command->reviewer(), 'max reviewers assigned'));
        }

        return EventStream::fromDomainEvents(new PullRequestReviewerAssigned($command->pullRequestId(), $command->reviewer()));
    }
}
