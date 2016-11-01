<?php
declare(strict_types=1);
namespace PTS\Routing;

use PTS\Tools\Collection;

class CollectionRoute extends Collection
{

    /**
     * @param string $name
     * @param Route $route
     * @param int $priority
     * @return $this
     * @throws \Exception
     */
    public function add($name, Route $route, $priority = 50)
    {
        return $this->addItem($name, $route, $priority);
    }

    /**
     * @param string $name
     * @return CollectionRoute
     */
    public function remove($name)
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
