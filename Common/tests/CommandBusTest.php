<?php

declare(strict_types=1);

namespace CommonTest;

use Common\Application\Command\Command;
use Common\Application\Command\CommandBus;
use Common\Application\Command\CommandMiddleware;
use Common\Application\Command\Middleware\MiddlewarePipelineFactory;
use PHPUnit\Framework\TestCase;

class CommandBusTest extends TestCase
{
    /**
     * @test
     */
    public function shouldExecuteAllMiddlewaresInBus()
    {
        $middleware1 = $this->middlewareSpy();
        $middleware2 = $this->middlewareSpy();
        $middleware3 = $this->middlewareSpy();

        $this
            ->commandBusFake(
                $middleware1,
                $middleware2,
                $middleware3
            )
            ->handle(
                $this->commandDummy()
            );

        $this->assertTrue($middleware1->isCalled());
        $this->assertTrue($middleware2->isCalled());
        $this->assertTrue($middleware3->isCalled());
    }

    private function commandDummy(): Command
    {
        return new class() implements Command {
        };
    }

    private function middlewareSpy(): CommandMiddleware
    {
        return new class() implements CommandMiddleware {
            /**
             * @var bool
             */
            private $isCalled = false;

            public function __invoke(Command $command, callable $nextMiddleware): void
            {
                $this->isCalled = true;

                $nextMiddleware($command);
            }

            public function isCalled(): bool
            {
                return $this->isCalled;
            }
        };
    }

    private function commandBusFake(CommandMiddleware ...$middlewares): CommandBus
    {
        return new class(...$middlewares) implements CommandBus {
            /**
             * @var CommandMiddleware[]
             */
            private $middlewares;

            public function __construct(CommandMiddleware ...$middlewares)
            {
                $this->middlewares = $middlewares;
            }

            public function handle(Command $command): void
            {
                $pipeline = MiddlewarePipelineFactory::create(...$this->middlewares);

                $pipeline($command);
            }
        };
    }
}
