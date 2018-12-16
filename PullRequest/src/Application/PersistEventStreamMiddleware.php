<?php


namespace PullRequest\Application;


use PullRequest\Domain\PullRequestRepository;
use Soa\EventSourcing\Command\Command;
use Soa\EventSourcing\Command\CommandMiddleware;
use Soa\EventSourcing\Command\CommandResponse;

class PersistEventStreamMiddleware implements CommandMiddleware
{
    /**
     * @var PullRequestRepository
     */
    private $repository;

    public function __construct(PullRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Command $command, callable $nextMiddleware): CommandResponse
    {
        /** @var CommandResponse $result */
        $result = $nextMiddleware($command);
        $this->repository->saveEventStream($result->eventStream());

        return $result;
    }
}
