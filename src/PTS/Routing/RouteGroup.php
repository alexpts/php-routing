<?php
namespace PTS\Routing;

use PTS\Routing\Traits\MiddlewaresTrait;

class RouteGroup
{
    use MiddlewaresTrait;

    /** @var array */
    protected $methods;
    /** @var string */
    protected $prefix;

    /**
     * @param string $prefix
     * @param array $methods
     */
    public function __construct(string $prefix = '', array $methods = [])
    {
        $this->methods = $methods;
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getPrefix() : string
    {
        return $this->prefix;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return null|callable
     */
    public function shiftMiddleware()
    {
        return count($this->getMiddlewares()) === 0
            ? null
            : array_shift($this->middlewares);
    }
}
