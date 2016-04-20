<?php
namespace PTS\Routing;

use Psr\Http\Message\RequestInterface;

class Route
{
    use Traits\Middlewares;

    /** @var string */
    protected $path;
    /** @var callable */
    protected $handler;
    /** @var [] */
    protected $handlerParams = [];
    /** @var array */
    protected $methods = [];
    /** @var RouteGroup */
    protected $group;
    /** @var array */
    protected $restrictions = [];
    /** @var array */
    protected $matches = [];

    /**
     * @param string $path
     * @param callable $handler
     */
    public function __construct(string $path, callable $handler)
    {
        $this->path = $path;
        $this->handler = $handler;
        $this->group = new RouteGroup();
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function __invoke(RequestInterface $request)
    {
        if ($middleware = $this->group->shiftMiddleware()) {
            return $middleware(... [$request, $this]);
        }

        if (count($this->middlewares) === 0) {
            return call_user_func_array($this->handler, $this->handlerParams);
        }

        $middleware = array_shift($this->middlewares);
        return $middleware(... [$request, $this]);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setHandlerParams(array $params = [])
    {
        $this->handlerParams = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getHandlerParams() : array
    {
        return $this->handlerParams;
    }

    /**
     * @param array $restrictions
     * @return $this
     */
    public function setRestrictions(array $restrictions)
    {
        $this->restrictions = $restrictions;
        return $this;
    }

    /**
     * @return array
     */
    public function getRestrictions() : array
    {
        return $this->restrictions;
    }

    /**
     * @param RouteGroup $group
     * @return $this
     */
    public function setGroup(RouteGroup $group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return RouteGroup|null
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        $path = $this->group ? $this->group->getPrefix() : '';
        $path .= $this->path;

        return $path;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setMatches(array $values = [])
    {
        $this->matches = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getMatches() : array
    {
        return $this->matches;
    }

    /**
     * @return array
     */
    public function getMethods() : array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
        return $this;
    }
}
