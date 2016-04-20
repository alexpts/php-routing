<?php
namespace PTS\Routing;

use PTS\Routing;

class Matcher
{
    /** @var RouteService */
    protected $routeService;
    /** @var Route */
    protected $routeNotFound;

    /**
     * @param RouteService $routeService
     */
    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
        $this->routeNotFound = new Route('', function(){
           return null;
        });
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function setNotFoundHandler(Route $route)
    {
        $this->routeNotFound = $route;
        return $this;
    }

    /**
     * @param CollectionRoute $routes
     * @param string $path
     * @return \Generator
     */
    public function match(CollectionRoute $routes, $path) : \Generator
    {
        foreach ($routes->getRoutes() as $route) {
            $activeRoute = $this->matchRule($route, $path);
            if ($activeRoute) {
                yield $activeRoute;
            }
        }

        yield $this->routeNotFound;
    }

    /**
     * @param Route $route
     * @param string $pathUrl
     * @return Route|null
     */
    protected function matchRule(Route $route, $pathUrl)
    {
        $regexp = $this->routeService->makeRegExp($route);

        if (preg_match('~^' .  $regexp . '$~Uiu', $pathUrl, $values)) {
            $filterValues = array_filter(array_keys($values), 'is_string');
            $matches = array_intersect_key($values, array_flip($filterValues));
            return $route->setMatches($matches);
        }

        return null;
    }
}
