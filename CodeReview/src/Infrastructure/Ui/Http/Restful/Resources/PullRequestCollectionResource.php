<?php

declare(strict_types=1);

namespace CodeReview\Infrastructure\Ui\Http\Restful\Resources;

use CodeReview\Application\Command\CreatePullRequestCommand;
use Common\Application\Command\CommandBus;
use Common\Infrastructure\Ui\Http\Restful\Resources\HttpResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PullRequestCollectionResource
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var HttpResponseFactory
     */
    private $responseFactory;

    public function __construct(CommandBus $commandBus, HttpResponseFactory $responseFactory)
    {
        $this->commandBus      = $commandBus;
        $this->responseFactory = $responseFactory;
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $requestBody = $request->getParsedBody();
            $this->commandBus->handle(new CreatePullRequestCommand($requestBody['code'], $requestBody['writer']));

            return $this->responseFactory->create()->withStatus(201);
        } catch (\InvalidArgumentException $exception) {
            return $this->responseFactory->create()->withStatus(422);
        }
    }
}
