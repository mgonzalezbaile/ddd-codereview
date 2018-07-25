<?php

declare(strict_types=1);

namespace Common\Application\Command;

use Common\Application\Command\Middleware\CommandHandlerSelectorMiddleware;
use Common\Application\Command\Middleware\LogCommandMiddleware;
use Common\Application\Command\Middleware\MiddlewarePipelineFactory;
use Common\Application\Command\Middleware\TransactionMiddleware;
use Common\Infrastructure\Persistence\DatabaseConnection;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class ConventionBasedCommandBus implements CommandBus
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function handle(Command $command): void
    {
        $pipeline = MiddlewarePipelineFactory::create(
            new LogCommandMiddleware($this->container->get(LoggerInterface::class)),
            new TransactionMiddleware($this->container->get(DatabaseConnection::class)),
            new CommandHandlerSelectorMiddleware($this->container)
        );

        $pipeline($command);
    }
}
