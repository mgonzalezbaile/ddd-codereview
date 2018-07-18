<?php

declare(strict_types=1);

namespace CodeReview\Application\Command;

use Common\Application\Command\Command;

class CreatePullRequestCommand implements Command
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

    public function __construct(string $id, string $code, string $writer)
    {
        $this->code   = $code;
        $this->id     = $id;
        $this->writer = $writer;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function writer(): string
    {
        return $this->writer;
    }
}
