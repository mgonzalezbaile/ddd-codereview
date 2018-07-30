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
        $executionTracker = $this->executionOrderTracker();

        $middleware1 = $this->middlewareSpy('first', $executionTracker);
        $middleware2 = $this->middlewareSpy('second', $executionTracker);
        $middleware3 = $this->middlewareSpy('third', $executionTracker);

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

        $this->assertEquals(['first', 'second', 'third'], $executionTracker->classesExecuted());
    }

    private function commandDummy(): Command
    {
        return new class() implements Command {
        };
    }

    private function executionOrderTracker()
    {
        return new class() {
            private $classesExecuted = [];

            public function trackExecution(string $classExecuted)
            {
                $this->classesExecuted[] = $classExecuted;
            }

            public function classesExecuted(): array
            {
                return $this->classesExecuted;
            }
        };
    }

    private function middlewareSpy(string $middlewareName, $executionTracker): CommandMiddleware
    {
        return new class($middlewareName, $executionTracker) implements CommandMiddleware {
            /**
             * @var bool
             */
            private $isCalled = false;

            /**
             * @var string
             */
            private $name;

            private $tracker;

            public function __construct(string $name, $tracker)
            {
                $this->name            = $name;
                $this->tracker         = $tracker;
            }

            public function __invoke(Command $command, callable $nextMiddleware): void
            {
                $this->isCalled = true;

                $this->tracker->trackExecution($this->name);

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
