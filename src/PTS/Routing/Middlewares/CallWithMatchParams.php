<?php
declare(strict_types = 1);

namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;

class CallWithMatchParams
{

    public function __invoke(RequestInterface $request, Route $route)
    {
        $args = array_filter($route->getMatches(), function ($name) {
            return strpos($name, '_') !== 0;
        }, \ARRAY_FILTER_USE_KEY);

        $route->getEndPoint()->setArgs($args);

        return $route($request);
    }
}
