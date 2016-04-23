<?php

use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\Middlewares\CallWithMatchParams;
use PTS\Routing\Point\ControllerPoint;
use PTS\Routing\Route;
use PTS\Routing\Point;
use PTS\Routing\RouteService;
use Zend\Diactoros\Request;
use PTS\Routing\Middlewares\RunPoint;

require_once __DIR__ . '/../Controller/DemoController.php';

class ControllerPointTest extends PHPUnit_Framework_TestCase
{

    /** @var Route */
    protected $route;
    /** @var ControllerPoint */
    protected $point;
    /** @var CollectionRoute */
    protected $coll;
    /** @var Matcher */
    protected $matcher;

    protected function setUp()
    {
        $this->coll = new CollectionRoute;
        $this->matcher = new Matcher(new RouteService());

        $this->point = new ControllerPoint([
            'controller' => \Controller\DemoController::class
        ]);

        $this->route = new Route('/profile/{name}/', $this->point);
    }

    public function testMiddlewareRunPointIndex()
    {
        $this->route->pushMiddleware(new RunPoint());
        $request = new Request('/profile/alex/');

        $this->coll->add('some', $this->route);
        $route = $this->matcher->match($this->coll, $request->getUri()->getPath())->current();

        self::assertEquals('index', $route($request));
    }

    public function testMiddlewareRunPointMatchAction()
    {
        $route = $this->route = new Route('/{_action}/{name}/', $this->point);
        $route->pushMiddleware(new CallWithMatchParams);
        $route->pushMiddleware(new RunPoint);

        $request = new Request('/profile/alex/');

        $this->coll->add('some', $this->route);
        $route = $this->matcher->match($this->coll, $request->getUri()->getPath())->current();

        self::assertEquals('profile:alex', $route($request));
    }

    public function testMiddlewareRunPointSetAction()
    {
        $this->point = new ControllerPoint([
            'controller' => \Controller\DemoController::class,
            'action' => 'profile',
        ]);

        $route = $this->route = new Route('/profile/{name}/', $this->point);
        $route->pushMiddleware(new CallWithMatchParams);
        $route->pushMiddleware(new RunPoint);

        $request = new Request('/profile/alex/');

        $this->coll->add('some', $this->route);
        $route = $this->matcher->match($this->coll, $request->getUri()->getPath())->current();

        self::assertEquals('profile:alex', $route($request));
    }

    public function testBadController()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Controller not found');

        $this->point = new ControllerPoint([
            'controller' => 'BadClass',
            'action' => 'profile',
        ]);

        $route = $this->route = new Route('/profile/{name}/', $this->point);
        $route->pushMiddleware(new CallWithMatchParams);
        $route->pushMiddleware(new RunPoint);

        $request = new Request('/profile/alex/');

        $this->coll->add('some', $this->route);
        $route = $this->matcher->match($this->coll, $request->getUri()->getPath())->current();

        self::assertEquals('profile:alex', $route($request));
    }

    public function testBadAction()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Action not found');

        $this->point = new ControllerPoint([
            'controller' => \Controller\DemoController::class,
            'action' => 'badAction',
        ]);

        $route = $this->route = new Route('/profile/{name}/', $this->point);
        $route->pushMiddleware(new CallWithMatchParams);
        $route->pushMiddleware(new RunPoint);

        $request = new Request('/profile/alex/');

        $this->coll->add('some', $this->route);
        $route = $this->matcher->match($this->coll, $request->getUri()->getPath())->current();

        self::assertEquals('profile:alex', $route($request));
    }

}
