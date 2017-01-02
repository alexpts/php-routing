<?php
declare(strict_types = 1);
namespace PTS\Routing;

class Matcher
{
    /** @var RouteService */
    protected $routeService;
    /** @var Route */
    protected $routeNotFound;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
        $this->routeNotFound = new Route('', function () {
            return null;
        });
    }

    public function setNotFoundHandler(Route $route)
    {
        $this->routeNotFound = $route;
        return $this;
    }

    public function match(CollectionRoute $routes, string $path) : \Generator
    {
        foreach ($routes->getRoutes() as $route) {
            $activeRoute = $this->matchRule($route, $path);
            if ($activeRoute !== null) {
                yield $activeRoute;
            }
        }

        yield $this->routeNotFound;
    }

    protected function matchRule(Route $route, string $pathUrl) : ? Route
    {
        $activeRoute = null;

        $regexp = $this->routeService->makeRegExp($route);

        if (preg_match('~^'.$regexp.'$~Uiu', $pathUrl, $values)) {
            $filterValues = array_filter(array_keys($values), 'is_string');
            $matches = array_intersect_key($values, array_flip($filterValues));
            $activeRoute = $route->setMatches($matches);
        }

        return $activeRoute;
    }
}
