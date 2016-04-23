<?php
namespace PTS\Routing\Point;

use PTS\Routing\Route;

class ControllerPoint extends AbstractPoint
{
    protected $controller;
    protected $action;

    /**
     * @param Route $route
     * @param array $args
     *
     * @return mixed
     */
    public function __invoke(Route $route, array $args = [])
    {
        $endPoint = $this->getPoint($route);
        return call_user_func_array($endPoint, $args);
    }

    /**
     * @param Route $route
     * @return callable
     */
    protected function getPoint(Route $route)
    {
        $matches = $route->getMatches();
        $controller = $this->getControllerClass();
        $this->checkController($controller);

        $controller = new $controller();

        $action = $this->getAction($matches);
        $this->checkAction($controller, $action);

        return [$controller, $action];
    }

    /**
     * @return string
     */
    protected function getControllerClass() : string
    {
        return $this->controller;
    }

    /**
     * @param $controller
     * @throws \BadMethodCallException
     */
    protected function checkController($controller)
    {
        if (!class_exists($controller)) {
            throw new \BadMethodCallException('Controller not found');
        }
    }

    /**
     * @param $controller
     * @param string $action
     * @throws \BadMethodCallException
     */
    protected function checkAction($controller, $action)
    {
        if (!method_exists($controller, $action)) {
            throw new \BadMethodCallException('Action not found');
        }
    }

    /**
     * @param array $matches
     * @return string
     */
    protected function getAction(array $matches = []) : string
    {
        return $matches['_action'] ?? $this->action ?? 'index';
    }

}
