<?php

use PHPUnit\Framework\TestCase;
use PTS\Routing\Route;
use PTS\Routing\RouteService;

class RouteServiceTest extends TestCase
{
    /** @var RouteService */
    protected $service;

    protected function setUp()
    {
        $this->service = new RouteService;
    }

    public function testCreate()
    {
        self::assertInstanceOf(RouteService::class, new RouteService);
    }

    public function testSimpleRegexp()
    {
        $route = new Route('/controller/action/', function(){});
        $regexp = $this->service->makeRegExp($route);
        self::assertEquals('/controller/action/', $regexp);
    }

    public function testRegexp()
    {
        $route = new Route('/controller/{action}/', function(){});
        $regexp = $this->service->makeRegExp($route);
        self::assertEquals('/controller/(?<action>[^\/]+)/', $regexp);
    }

    public function testRegexpWithRestriction()
    {
        $route = new Route('/controller/{action}/', function(){});
        $route->setRestrictions(['action' => '\w+']);

        $regexp = $this->service->makeRegExp($route);
        self::assertEquals('/controller/(?<action>\w+)/', $regexp);
    }
}
