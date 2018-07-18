<?php

declare(strict_types=1);

namespace CodeReview\Domain;

use Webmozart\Assert\Assert;

class PullRequest
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $writer;

    public function __construct(PullRequestRepository $repository, string $code, string $writer)
    {
        $this->setId($repository->nextIdentity());
        $this->setCode($code);
        $this->setWriter($writer);
    }

    public function id(): string
    {
        return $this->id;
    }

    private function setCode(string $code): void
    {
        Assert::notEmpty($code);

        $this->code = $code;
    }

    private function setId(string $id): void
    {
        Assert::uuid($id);

        $this->id = $id;
    }

    private function setWriter(string $writer): void
    {
        Assert::notEmpty($writer);

        $this->writer = $writer;
    }
}
