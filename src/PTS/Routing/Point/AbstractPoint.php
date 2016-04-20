<?php
namespace PTS\Routing\Point;

abstract class AbstractPoint
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $name => $param) {
            if (property_exists($this, $name)) {
                $this->{$name} = $param;
            }
        }
    }
}
