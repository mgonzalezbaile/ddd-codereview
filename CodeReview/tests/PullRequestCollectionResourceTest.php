<?php

declare(strict_types=1);

namespace CodeReviewTest;

use CodeReview\Infrastructure\Di\ServicesDefinition;
use CodeReview\Infrastructure\Ui\Http\Restful\Resources\PullRequestCollectionResource;
use Common\Application\Command\CommandBus;
use Common\Infrastructure\Application\BasicContainer;
use Common\Infrastructure\Ui\Http\Restful\Resources\BasicHttpRequest;
use Common\Infrastructure\Ui\Http\Restful\Resources\HttpResponseFactory;
use PHPUnit\Framework\TestCase;

class PullRequestCollectionResourceTest extends TestCase
{
    /**
     * @var PullRequestCollectionResource
     */
    private $resource;

    public function setUp()
    {
        $container      = new BasicContainer(ServicesDefinition::all());
        $this->resource = new PullRequestCollectionResource($container->get(CommandBus::class), $container->get(HttpResponseFactory::class));
    }

    /**
     * @test
     */
    public function shouldReturn201()
    {
        $this->markTestSkipped();

        $response = $this->resource->post((new BasicHttpRequest())->withParsedBody(['writer' => 'some writer', 'code' => 'some code']));

        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturn409()
    {
        $this->markTestSkipped();

        $response = $this->resource->post((new BasicHttpRequest())->withParsedBody(['writer' => '', 'code' => 'some code']));

        $this->assertEquals(422, $response->getStatusCode());
    }
}
