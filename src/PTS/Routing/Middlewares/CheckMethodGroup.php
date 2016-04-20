<?php
namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;

class CheckMethodGroup
{
    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return mixed
     */
    public function __invoke(RequestInterface $request, Route $route)
    {
        $supports = $route->getGroup()->getMethods();
        if (count($supports) > 0 && !in_array($request->getMethod(), $supports, true)) {
            return null;
        }

        return $route($request);
    }
}