<?php
namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;

class CallWithMatchParams
{
    /**
     * @param RequestInterface $request
     * @param Route $route
     * @return mixed
     */
    public function __invoke(RequestInterface $request, Route $route)
    {
        $args = array_filter($route->getMatches(), function($name){
            return strpos($name, '_') !== 0;
        }, \ARRAY_FILTER_USE_KEY);

        $route->setHandlerParams($args);

        return $route($request);
    }
}
