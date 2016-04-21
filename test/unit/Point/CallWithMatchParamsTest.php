<?php

use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\RouteService;
use PTS\Routing\Route;
use PTS\Routing\Point;
use PTS\Routing\Middlewares\CallWithMatchParams;
use Zend\Diactoros\Request;

class CallWithMatchParamsTest extends PHPUnit_Framework_TestCase
{

    public function testMiddleware()
    {
        $route = new Route('/profile/{name}/', function ($name) {
            return $name;
        });
        $route->pushMiddleware(new CallWithMatchParams);

        $coll = new CollectionRoute;
        $coll->add('profile', $route);

        $path = '/profile/alex/';
        $matcher = new Matcher(new RouteService());
        $activeRoute = $matcher->match($coll, $path)->current();

        self::assertEquals('alex', $activeRoute(new Request($path)));
    }
}