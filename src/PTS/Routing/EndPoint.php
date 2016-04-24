<?php
namespace PTS\Routing;

class EndPoint
{
    /** @var callable */
    protected $handler;
    /** @var array */
    protected $args = [];

    /**
     * @param callable $handler
     * @param array $args
     */
    public function __construct(callable $handler, array $args = [])
    {
        $this->handler = $handler;
        $this->args = $args;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->handler, $this->args);
    }

    /**
     * @param array $args
     * @return $this
     */
    public function setArgs(array $args = [])
    {
        $this->args = $args;
        return $this;
    }

    /**
     * @return array
     */
    public function getArgs() : array
    {
        return $this->args;
    }
}
