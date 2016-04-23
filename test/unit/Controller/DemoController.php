<?php
namespace Controller;

class DemoController
{
    public function index()
    {
        return 'index';
    }

    /**
     * @param string $name
     * @return string
     */
    public function profile($name = '')
    {
        return 'profile:' . $name ;
    }
}
