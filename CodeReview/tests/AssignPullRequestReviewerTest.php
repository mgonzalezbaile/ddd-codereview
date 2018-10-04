<?php

declare(strict_types=1);

namespace CodeReviewTest;

use CodeReview\Application\Command\AssignPullRequestReviewerCommand;
use CodeReview\Application\Command\AssignPullRequestReviewerCommandHandler;
use CodeReview\Domain\Event\PullRequestReviewerAssigned;
use CodeReview\Domain\Event\PullRequestReviewerAssignationFailed;
use CodeReview\Domain\PullRequestState;
use CodeReview\Infrastructure\Persistence\InMemory\InMemoryPullRequestRepository;
use Common\Domain\Event\EventStream;
use PHPUnit\Framework\TestCase;

class AssignPullRequestReviewerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAssignReviewer()
    {
        //GIVEN
        $id           = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $pullRequest  = new PullRequestState($id);
        $repository   = InMemoryPullRequestRepository::withRandomId();
        $repository->save($pullRequest);

        //WHEN
        $reviewer       = 'some reviewer';
        $command        = new AssignPullRequestReviewerCommand($id, $reviewer);
        $commandHandler = new AssignPullRequestReviewerCommandHandler($repository);
        $commandHandler->handle($command);

        //THEN
        $this->assertEquals(EventStream::fromDomainEvents(new PullRequestReviewerAssigned($id, $reviewer)), $repository->eventStream());
    }

    /**
     * @test
     */
    public function shouldFail_when_reviewerWasAlreadyAssigned()
    {
        //GIVEN
        $id             = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $reviewer       = 'some reviewer';
        $pullRequest    = new PullRequestState($id, [$reviewer]);
        $repository     = InMemoryPullRequestRepository::withRandomId();
        $repository->save($pullRequest);

        //WHEN
        $command        = new AssignPullRequestReviewerCommand($id, $reviewer);
        $commandHandler = new AssignPullRequestReviewerCommandHandler($repository);
        $commandHandler->handle($command);

        //THEN
        $this->assertEquals(EventStream::fromDomainEvents(new PullRequestReviewerAssignationFailed($id, $reviewer, 'max reviewers assigned')), $repository->eventStream());
    }

    /**
     * @test
     */
    public function shouldFail_when_emptyReviewer()
    {
        //GIVEN
        $id           = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $pullRequest  = new PullRequestState($id);
        $repository   = InMemoryPullRequestRepository::withRandomId();
        $repository->save($pullRequest);

        //WHEN
        $reviewer       = '';
        $command        = new AssignPullRequestReviewerCommand($id, $reviewer);
        $commandHandler = new AssignPullRequestReviewerCommandHandler($repository);
        $commandHandler->handle($command);

        //THEN
        $this->assertEquals(EventStream::fromDomainEvents(new PullRequestReviewerAssignationFailed($id, $reviewer, 'empty reviewer')), $repository->eventStream());
    }
}
