<?php
namespace PTS\Routing;

class CollectionRoute
{
    /** @var [] */
    protected $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function isHas($name) : bool
    {
        foreach ($this->routes as $items) {
            if (array_key_exists($name, $items)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @param Route $route
     * @param int $priority
     * @return $this
     * @throws \Exception
     */
    public function add($name, Route $route, $priority = 50)
    {
        if ($this->isHas($name)) {
            throw new \OverflowException('Route with the same name already exists');
        }

        $this->routes[$priority][$name] = $route;
        return $this;
    }

    /**
     * @param string $name
     * @return CollectionRoute
     */
    public function remove($name)
    {
        foreach ($this->routes as $priority => $items) {
            if (isset($items[$name])) {
                $this->removeWithPriority($name, $priority);
            }
        }

        return $this;
    }

    /**
     * @param string $name
     * @param int $priority
     * @return $this
     */
    public function removeWithPriority($name, $priority = 50)
    {
        if (isset($this->routes[$priority][$name])) {
            unset($this->routes[$priority][$name]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clean()
    {
        $this->routes = [];
        return $this;
    }

    /**
     * @return Route[]
     */
    public function getRoutes() : array
    {
        $listRoutes = [];
        krsort($this->routes, SORT_NUMERIC);

        foreach ($this->routes as $routes) {
            foreach ($routes as $name => $route) {
                $listRoutes[$name] = $route;
            }
        }

        return $listRoutes;
    }
}
