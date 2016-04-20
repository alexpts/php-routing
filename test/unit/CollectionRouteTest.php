<?php

use PTS\Routing\CollectionRoute;
use PTS\Routing\Route;
use PTS\Routing\Point;

class CollectionRouteTest extends PHPUnit_Framework_TestCase
{
    /** @var CollectionRoute */
    protected $routes;

    public $endPoint;

    protected function setUp()
    {
        $this->routes = new CollectionRoute();
        $this->endPoint = function(){};
    }

    public function testCreate()
    {
        self::assertCount(0, $this->routes->getRoutes());
    }

    public function testAdd()
    {
        $this->routes->add('default', new Route('/blog/', $this->endPoint));
        $routes = $this->routes->getRoutes();

        self::assertCount(1, $routes);
        self::assertTrue(array_key_exists('default', $routes));
    }

    public function testAddDuplicate()
    {
        $this->expectException(OverflowException::class);
        $this->expectExceptionMessage('Route with the same name already exists');

        $this->routes->add('default', new Route('/blog/', $this->endPoint));
        $this->routes->add('default', new Route('/category/', $this->endPoint));
    }

    public function testClean()
    {
        $this->routes->add('default', new Route('/blog/', $this->endPoint));
        $this->routes->clean();
        $routes = $this->routes->getRoutes();

        self::assertCount(0, $routes);
    }

    public function testRemove()
    {
        $this->routes->add('default', new Route('/blog/', $this->endPoint));
        $this->routes->remove('default');
        $routes = $this->routes->getRoutes();

        self::assertCount(0, $routes);
    }

    public function testRemoveWithPriority()
    {
        $this->routes->add('default', new Route('/blog/', $this->endPoint), 70);
        $this->routes->add('cats', new Route('/cats/', $this->endPoint), 50);
        $this->routes->removeWithPriority('default', 70);
        $routes = $this->routes->getRoutes();

        self::assertCount(1, $routes);
    }

    public function testPriority()
    {
        $this->routes->add('default', new Route('/blog/', $this->endPoint), 70);
        $this->routes->add('cats', new Route('/cats/', $this->endPoint), 50);
        $this->routes->add('profile', new Route('/cats/', $this->endPoint), 60);
        $routes = $this->routes->getRoutes();

        self::assertEquals(['default', 'profile', 'cats'], array_keys($routes));
    }
}