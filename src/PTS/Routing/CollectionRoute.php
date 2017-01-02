<?php
declare(strict_types = 1);
namespace PTS\Routing;

use PTS\Tools\Collection;

class CollectionRoute extends Collection
{

    public function add(string $name, Route $route, int $priority = 50)
    {
        return $this->addItem($name, $route, $priority);
    }

    public function remove(string $name) : CollectionRoute
    {
        return $this->removeItemWithoutPriority($name);
    }

    /**
     * @return Route[]
     */
    public function getRoutes() : array
    {
        return $this->getFlatItems(true);
    }
}
