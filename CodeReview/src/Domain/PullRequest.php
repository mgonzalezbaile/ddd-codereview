<?php

declare(strict_types=1);

namespace CodeReview\Domain;

use CodeReview\Application\Command\AssignPullRequestReviewerCommand;
use CodeReview\Application\Command\CreatePullRequestCommand;
use CodeReview\Domain\Event\PullRequestCreated;
use CodeReview\Domain\Event\PullRequestReviewed;
use CodeReview\Domain\Exception\AssignReviewerException;
use Common\Domain\Event\EventStream;
use Webmozart\Assert\Assert;

class PullRequest
{
    public static function create(PullRequestRepository $repository, CreatePullRequestCommand $command): EventStream
    {
        $id = $repository->nextIdentity();

        Assert::notEmpty($command->code());
        Assert::uuid($id);
        Assert::notEmpty($command->writer());

        return EventStream::fromDomainEvents(new PullRequestCreated($id, $command->writer(), $command->code()));
    }

    public static function assignReviewer(PullRequestState $state, AssignPullRequestReviewerCommand $command): EventStream
    {
        Assert::notEmpty($command->reviewer());

        if (in_array($command->reviewer(), $state->reviewers())) {
            throw AssignReviewerException::becauseReviewerAlreadyAssigned($command->pullRequestId(), $command->reviewer());
        }

        return EventStream::fromDomainEvents(new PullRequestReviewed($command->pullRequestId(), $command->reviewer()));
    }
}
