<?php

declare(strict_types=1);

namespace PullRequest\Application;

use Psr\Container\ContainerInterface;
use PullRequest\Domain\PullRequestRepository;
use Soa\EventSourcing\Command\Command;
use Soa\EventSourcing\Command\CommandBus;
use Soa\EventSourcing\Command\CommandResponse;
use Soa\EventSourcingMiddleware\Middleware\CommandHandlerSelectorMiddleware;
use Soa\EventSourcingMiddleware\Middleware\MiddlewarePipelineFactory;
use Soa\EventSourcingMiddleware\Middleware\TransactionMiddleware;
use Soa\EventSourcingMiddleware\Persistence\DatabaseSession;
use Soa\Traceability\Trace;

class PullRequestCommandBus implements CommandBus
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Trace
     */
    private $trace;

    public function __construct(ContainerInterface $container, Trace $trace)
    {
        $this->container = $container;
        $this->trace     = $trace;
    }

    public function handle(Command $command): CommandResponse
    {
        $pipeline = MiddlewarePipelineFactory::create(
            new TransactionMiddleware($this->container->get(DatabaseSession::class)),
            new PersistEventStreamMiddleware($this->container->get(PullRequestRepository::class)),
            new CommandHandlerSelectorMiddleware($this->container, $this->container->get(PullRequestRepository::class))
        );

        return $pipeline($command);
    }
}
