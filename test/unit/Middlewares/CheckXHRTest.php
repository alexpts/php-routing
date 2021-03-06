<?php

use PHPUnit\Framework\TestCase;
use PTS\Routing\Middlewares\CheckXHR;
use PTS\Routing\Route;
use Zend\Diactoros\Request;

class CheckXHRTest extends TestCase
{

    /** @var Route */
    protected $route;

    protected function setUp()
    {
        $this->route = new Route('/profile/{name}/', function () {
            return 200;
        });
    }

    public function testMiddlewareXHR()
    {
        $route = $this->route;
        $this->route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_XHR));

        $request = new Request('/profile/alex/');
        $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');

        self::assertEquals(200, $route($request));
    }

    public function testMiddlewareXHRBad()
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_XHR));

        $request = new Request('/profile/alex/');

        self::assertEquals(null, $route($request));
    }

    public function testMiddlewareNoXHR()
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_NO_XHR));

        $request = new Request('/profile/alex/');
        
        self::assertEquals(200, $route($request));
    }

    public function testMiddlewareNoXHRBad()
    {
        $route = $this->route;
        $route->pushMiddleware(new CheckXHR(CheckXHR::ONLY_NO_XHR));

        $request = new Request('/profile/alex/');
        $request = $request->withHeader('X-Requested-With', 'XMLHttpRequest');

        self::assertEquals(null, $route($request));
    }
}
