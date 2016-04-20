<?php
namespace PTS\Routing;

class RouteGroup
{
    use Traits\Middlewares;

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
        return count($this->middlewares) === 0
            ? null
            : array_shift($this->middlewares);
    }
}
