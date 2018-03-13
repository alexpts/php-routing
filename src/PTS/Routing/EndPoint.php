<?php
declare(strict_types = 1);

namespace PTS\Routing;

class EndPoint
{
    /** @var callable */
    protected $handler;
    /** @var array */
    protected $args = [];

    public function __construct(callable $handler, array $args = [])
    {
        $this->handler = $handler;
        $this->args = $args;
    }

    public function __invoke()
    {
        return \call_user_func_array($this->handler, $this->args);
    }

    public function setArgs(array $args = []): self
    {
        $this->args = $args;
        return $this;
    }

    public function getArgs(): array
    {
        return $this->args;
    }
}
