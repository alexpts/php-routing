<?php

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /** @var Route */
    protected $route;
    public $endPoint;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endPoint = function () {
            return 'response';
        };
        $this->route = new Route('/', $this->endPoint);
    }

    public function testCreate(): void
    {
        $route = new Route('/', $this->endPoint);
        self::assertInstanceOf(Route::class, $route);
    }

    public function testInvoke(): void
    {
        $request = new \Zend\Diactoros\Request('/');
        $route = $this->route;
        self::assertEquals('response', $route($request));
    }

    public function testEndPointsParams(): void
    {
        $data = [
            'a' => 1,
            'b' => 'some'
        ];

        $this->route->getEndPoint()->setArgs($data);
        $params = $this->route->getEndPoint()->getArgs();

        self::assertEquals($data, $params);
    }

    public function testPath(): void
    {
       self::assertEquals('/', $this->route->getPath());
    }

    public function testMethods(): void
    {
        $data = ['get', 'post'];
        $this->route->setMethods($data);
        self::assertEquals($data, $this->route->getMethods());
    }

    public function testMatches(): void
    {
        $data = ['controller' => 'demo', 'action' => 'index'];
        $this->route->setMatches($data);
        self::assertEquals($data, $this->route->getMatches());
    }

    public function testRestrictions(): void
    {
        $data = ['controller' => '\w+', 'id' => '\d+'];
        $this->route->setRestrictions($data);
        self::assertEquals($data, $this->route->getRestrictions());
    }

    public function testMiddleware(): void
    {
        $this->route->pushMiddleware(function(RequestInterface $request, callable $next) {
            $response = $next($request);
            return $response . '2';
        });

        $request = new \Zend\Diactoros\Request('/');
        $route = $this->route;
        self::assertEquals('response2', $route($request));
    }
}