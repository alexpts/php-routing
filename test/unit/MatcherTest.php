<?php

use PHPUnit\Framework\TestCase;
use PTS\Routing\Route;
use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\RouteService;
use PTS\Tools\DuplicateKeyException;
use Zend\Diactoros\Request;

class MatcherTest extends TestCase
{
    /** @var CollectionRoute */
    protected $coll;
    /** @var Matcher */
    protected $matcher;

    /**
     * @throws DuplicateKeyException
     */
    protected function setUp(): void
    {
        $this->coll = new CollectionRoute();

        $this->coll->add('main', new Route('/', function(){
            return 'main';
        }));

        $this->coll->add('dynamic', new Route('/{controller}/({action}/)?', function(){
            return 'dynamic';
        }));

        $this->coll->add('blog', new Route('/web/blog/{id}/', function(){
            return 'blog';
        }));

        $this->matcher = new Matcher(new RouteService());
    }

    public function testCreate(): void
    {
        $matcher = new Matcher(new RouteService);
        self::assertInstanceOf(Matcher::class, $matcher);
    }

    public function testNotFoundHandler(): void
    {
        $this->matcher->setNotFoundHandler(new Route('/404', function(){
            return 404;
        }));

        /** @var Route $route */
        $route = $this->matcher->match($this->coll, '/none/some/none/')->current();
        self::assertEquals('/404', $route->getPath());
    }

    public function testMatchOnGreedy(): void
    {
        /** @var Route $route */
        $route = $this->matcher->match($this->coll, '/post/delete/')->current();
        self::assertEquals('/{controller}/({action}/)?', $route->getPath());
        self::assertEquals(['action' => 'delete', 'controller' => 'post'], $route->getMatches());
    }

    public function testMatch(): void
    {
        /** @var Route $route */
        $route = $this->matcher->match($this->coll, '/web/blog/3/')->current();
        self::assertEquals('/web/blog/{id}/', $route->getPath());
        self::assertEquals(['id' => '3'], $route->getMatches());
    }

    public function testDefaulNotFoundRoutetNullHandler(): void
    {
        $request = new Request('/', 'GET');
        /** @var Route $route */
        $route = $this->matcher->match(new CollectionRoute, '/not-found')->current();
        self::assertNull($route($request));
    }
}
