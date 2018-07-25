<?php

declare(strict_types=1);

namespace CodeReview\Infrastructure\Di;

use CodeReview\Application\Command\CreatePullRequestCommandHandler;
use CodeReview\Infrastructure\Persistence\InMemory\InMemoryPullRequestRepository;
use Common\Application\Command\CommandBus;
use Common\Application\Command\ConventionBasedCommandBus;
use Common\Infrastructure\Persistence\DatabaseConnection;
use Common\Infrastructure\Ui\Http\Restful\Resources\BasicHttpResponse;
use Common\Infrastructure\Ui\Http\Restful\Resources\HttpResponseFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ServicesDefinition
{
    public static function all()
    {
        return [
            CommandBus::class => function (ContainerInterface $container): ConventionBasedCommandBus {
                return new ConventionBasedCommandBus($container);
            },

            DatabaseConnection::class => function (ContainerInterface $container): DatabaseConnection {
                return new class() implements DatabaseConnection {
                    public function beginTransaction(): void
                    {
                        // TODO: Implement beginTransaction() method.
                    }

                    public function commitTransaction(): void
                    {
                        // TODO: Implement commitTransaction() method.
                    }

                    public function rollbackTransaction(): void
                    {
                        // TODO: Implement rollbackTransaction() method.
                    }
                };
            },

            CreatePullRequestCommandHandler::class => function (ContainerInterface $container): CreatePullRequestCommandHandler {
                return new CreatePullRequestCommandHandler(InMemoryPullRequestRepository::withRandomId());
            },

            HttpResponseFactory::class => function (ContainerInterface $container): HttpResponseFactory {
                return new class() implements HttpResponseFactory {
                    public function create(): ResponseInterface
                    {
                        return new BasicHttpResponse();
                    }
                };
            },

            LoggerInterface::class => function (ContainerInterface $container): LoggerInterface {
                return new NullLogger();
            },
        ];
    }
}
