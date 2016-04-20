<?php

use PTS\Routing\Route;
use PTS\Routing\Point;
use PTS\Routing\CollectionRoute;
use PTS\Routing\Matcher;
use PTS\Routing\RouteService;

class MatcherTest extends PHPUnit_Framework_TestCase
{
    /** @var CollectionRoute */
    protected $coll;
    /** @var Matcher */
    protected $matcher;

    protected function setUp()
    {
        $this->coll = new CollectionRoute();

        $this->coll->add('main', new Route('/', function(){
            return 'main';
        }));

        $this->coll->add('blog', new Route('/blog/{id}/', function(){
            return 'blog';
        }));

        $this->matcher = new Matcher(new RouteService());
    }

    public function testCreate()
    {
        new Matcher(new RouteService());
    }

    public function testNotFoundHandler()
    {
        $this->matcher->setNotFoundHandler(new Route('/404', function(){
            return 404;
        }));

        /** @var Route $route */
        $route = $this->matcher->match($this->coll, '/none/')->current();
        self::assertEquals('/404', $route->getPath());
    }

    public function testMatch()
    {
        /** @var Route $route */
        $route = $this->matcher->match($this->coll, '/blog/3/')->current();
        self::assertEquals('/blog/{id}/', $route->getPath());
        self::assertEquals(['id' => '3'], $route->getMatches());
    }
}