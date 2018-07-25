<?php

declare(strict_types=1);

namespace Common\Application\Command\Middleware;

use Common\Application\Command\Command;
use Common\Application\Command\CommandMiddleware;
use Psr\Container\ContainerInterface;

class CommandHandlerSelectorMiddleware implements CommandMiddleware
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Command $command, callable $nextMiddleware): void
    {
        $handler = $this->container->get(get_class($command) . 'Handler');

        $handler->handle($command);
    }
}
