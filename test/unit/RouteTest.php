<?php

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;
use PTS\Routing\Point;
use PTS\Routing\RouteGroup;

class RouteTest extends PHPUnit_Framework_TestCase
{
    /** @var Route */
    protected $route;
    public $endPoint;

    protected function setUp()
    {
        $this->endPoint = function(){
            return 'response';
        };
        $this->route = new Route('/', $this->endPoint);
    }

    public function testCreate()
    {
        new Route('/', $this->endPoint);
    }

    public function testInvoke()
    {
        $request = new \Zend\Diactoros\Request('/');
        $route = $this->route;
        self::assertEquals('response', $route($request));
    }

    public function testHandleParams()
    {
        $data = [
            'a' => 1,
            'b' => 'some'
        ];

        $this->route->setHandlerParams($data);
        $params = $this->route->getHandlerParams();

        self::assertEquals($data, $params);
    }

    public function testPath()
    {
       self::assertEquals('/', $this->route->getPath());
    }

    public function testMethods()
    {
        $data = ['get', 'post'];
        $this->route->setMethods($data);
        self::assertEquals($data, $this->route->getMethods());
    }

    public function testMatches()
    {
        $data = ['controller' => 'demo', 'action' => 'index'];
        $this->route->setMatches($data);
        self::assertEquals($data, $this->route->getMatches());
    }

    public function testRestrictions()
    {
        $data = ['controller' => '\w+', 'id' => '\d+'];
        $this->route->setRestrictions($data);
        self::assertEquals($data, $this->route->getRestrictions());
    }

    public function testGroup()
    {
        $group = new RouteGroup();
        $this->route->setGroup($group);
        self::assertEquals($group, $this->route->getGroup());
    }

    public function testMiddleware()
    {
        $this->route->pushMiddleware(function(RequestInterface $request, callable $next){
            $response = $next($request);
            return $response . '2';
        });

        $request = new \Zend\Diactoros\Request('/');
        $route = $this->route;
        self::assertEquals('response2', $route($request));
    }

    public function testMiddlewareGroup()
    {
        $group = new RouteGroup();
        $this->route->setGroup($group);

        $group->pushMiddleware(function(RequestInterface $request, callable $next){
            $response = $next($request);
            return $response . '2';
        });

        $request = new \Zend\Diactoros\Request('/');
        $route = $this->route;
        self::assertEquals('response2', $route($request));
    }
}