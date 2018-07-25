<?php

declare(strict_types=1);

namespace CodeReviewTest;

use CodeReview\Application\Command\CreatePullRequestCommand;
use CodeReview\Application\Command\CreatePullRequestCommandHandler;
use CodeReview\Domain\PullRequest;
use CodeReview\Infrastructure\Persistence\InMemory\InMemoryPullRequestRepository;
use PHPUnit\Framework\TestCase;

class CreatePullRequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreatePullRequest()
    {
        $code       = 'some code';
        $id         = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $writer     = 'some writer';
        $repository = InMemoryPullRequestRepository::withFixedId($id);

        $command        = new CreatePullRequestCommand($code, $writer);
        $commandHandler = new CreatePullRequestCommandHandler($repository);
        $commandHandler->handle($command);

        $pullRequestCreated  = $repository->findOfId($id);
        $pullRequestExpected = new PullRequest($repository, $code, $writer);
        $this->assertEquals($pullRequestCreated, $pullRequestExpected);
    }

    /**
     * @test
     */
    public function shouldFail_when_emptyCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $code       = '';
        $id         = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $writer     = 'some writer';
        $repository = InMemoryPullRequestRepository::withFixedId($id);

        $command        = new CreatePullRequestCommand($code, $writer);
        $commandHandler = new CreatePullRequestCommandHandler($repository);
        $commandHandler->handle($command);
    }

    /**
     * @test
     */
    public function shouldFail_when_emptyWriter()
    {
        $this->expectException(\InvalidArgumentException::class);

        $code       = 'some code';
        $id         = 'e0b5b77f-3e19-4002-b710-8a89c6c64836';
        $writer     = '';
        $repository = InMemoryPullRequestRepository::withFixedId($id);

        $command        = new CreatePullRequestCommand($code, $writer);
        $commandHandler = new CreatePullRequestCommandHandler($repository);
        $commandHandler->handle($command);
    }
}
