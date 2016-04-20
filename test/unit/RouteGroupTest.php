<?php

use PTS\Routing\Point;
use PTS\Routing\RouteGroup;

class RouteGroupTest extends PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        new RouteGroup('/');
    }

    public function testPrefix()
    {
        $group = new RouteGroup('/');
        self::assertEquals('/', $group->getPrefix());
    }

    public function testMethods()
    {
        $group = new RouteGroup('/', ['post']);
        self::assertEquals(['post'], $group->getMethods());
    }
}