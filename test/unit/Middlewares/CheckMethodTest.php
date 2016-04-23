<?php

use PTS\Routing\Middlewares\CheckMethod;
use PTS\Routing\Route;
use PTS\Routing\Point;
use Zend\Diactoros\Request;

class CheckMethodTest extends PHPUnit_Framework_TestCase
{

    /** @var Route */
    protected $route;

    protected function setUp()
    {
        $this->route = new Route('/profile/{name}/', function () {
            return 200;
        });
    }

    public function testMiddlewareOk()
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckMethod);
        $route->setMethods(['get']);

        self::assertEquals(200, $route(new Request('/profile/alex/', 'get')));
    }
    
    public function testMiddlewareSkipRoute()
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckMethod);
        $route->setMethods(['post']);

        self::assertEquals(null, $route(new Request('/profile/alex/', 'get')));
    }
}
