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
    private $writer;

    public function __construct(string $code, string $writer)
    {
        $this->code   = $code;
        $this->writer = $writer;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function writer(): string
    {
        return $this->writer;
    }
}
