<?php
namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;

class RunPoint
{
    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return mixed
     */
    public function __invoke(RequestInterface $request, Route $route)
    {
        $endpoint = $route->getEndPoint();
        $endpoint->setArgs([$route, $endpoint->getArgs()]);

        return $route($request);
    }
}
