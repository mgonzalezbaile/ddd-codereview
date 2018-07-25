<?php

declare(strict_types=1);

namespace Common\Application\Command\Middleware;

use Common\Application\Command\Command;
use Common\Application\Command\CommandMiddleware;

class MiddlewarePipelineFactory
{
    public static function create(CommandMiddleware ...$middlewares): callable
    {
        $nextMiddleware = function (Command $command) {};

        foreach ($middlewares as $middleware) {
            $nextMiddleware = function (Command $command) use ($middleware, $nextMiddleware) {
                $middleware($command, $nextMiddleware);
            };
        }

        return $nextMiddleware;
    }
}
