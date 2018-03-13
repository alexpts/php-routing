<?php
declare(strict_types = 1);

namespace PTS\Routing;

use PTS\Tools\Collection;
use PTS\Tools\DuplicateKeyException;

class CollectionRoute extends Collection
{

    /**
     * @param string $name
     * @param Route $route
     * @param int $priority
     *
     * @return $this
     *
     * @throws DuplicateKeyException
     */
    public function add(string $name, Route $route, int $priority = 50): self
    {
        return $this->addItem($name, $route, $priority);
    }

    public function remove(string $name): self
    {
        return $this->removeItemWithoutPriority($name);
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->getFlatItems(true);
    }
}
