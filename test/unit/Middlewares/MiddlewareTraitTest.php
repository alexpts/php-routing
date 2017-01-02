<?php

use PTS\Routing\Middlewares\CheckXHR;
use PTS\Routing\Route;
use Zend\Diactoros\Request;

class MiddlewareTraitTest extends PHPUnit_Framework_TestCase
{
    /** @var Route */
    protected $route;

    protected function setUp() : void
    {
        $this->route = new Route('/profile/{name}/', function () {
            return 200;
        });
    }

    public function testMiddlewareXHR() : void
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_XHR));

        $request = new Request('/profile/alex/');
        $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');

        self::assertEquals(200, $route($request));
    }

    public function testMiddlewareXHRBad() : void
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_XHR));

        $request = new Request('/profile/alex/');

        self::assertEquals(null, $route($request));
    }

    public function testMiddlewareNoXHR() : void
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_NO_XHR));

        $request = new Request('/profile/alex/');

        self::assertEquals(200, $route($request));
    }

    public function testMiddlewareNoXHRBad() : void
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_NO_XHR));

        $request = new Request('/profile/alex/');
        $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');

        self::assertEquals(null, $route($request));
    }
}
