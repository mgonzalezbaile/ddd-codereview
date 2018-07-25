<?php

declare(strict_types=1);

namespace Common\Infrastructure\Ui\Http\Restful\Resources;

use Psr\Http\Message\ResponseInterface;

interface HttpResponseFactory
{
    public function create(): ResponseInterface;
}
