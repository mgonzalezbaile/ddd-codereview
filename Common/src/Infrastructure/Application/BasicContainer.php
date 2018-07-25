<?php

declare(strict_types=1);

namespace Common\Infrastructure\Application;

use Psr\Container\ContainerInterface;

class BasicContainer implements ContainerInterface
{
    /**
     * @var array
     */
    private $servicesDefinition;

    public function __construct(array $servicesDefinition)
    {
        $this->servicesDefinition = $servicesDefinition;
    }

    public function get($id)
    {
        $serviceFactory = $this->servicesDefinition[$id];

        return $serviceFactory($this);
    }

    public function has($id)
    {
        return isset($this->servicesDefinition[$id]);
    }
}
