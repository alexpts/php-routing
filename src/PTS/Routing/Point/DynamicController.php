<?php
namespace PTS\Routing\Point;

use PTS\Routing\Route;

class DynamicController extends ControllerPoint
{
    protected $prefix = '';

    /** @var Route */
    protected $route;

    /**
     * @param Route $route
     * @param array $args
     *
     * @return mixed
     */
    public function __invoke(Route $route, array $args = [])
    {
        $this->route = $route;
        parent::__invoke($route, $args);
    }

    /**
     * @return string
     */
    protected function getControllerClass() : string
    {
        $matches = $this->route->getMatches();

        if (!array_key_exists('_controller', $matches)) {
            throw new \BadMethodCallException('Not found controller name for dynamic controller point');
        }

        return $this->prefix . ucfirst($matches['_controller']);
    }
}
