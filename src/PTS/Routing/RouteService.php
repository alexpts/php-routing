<?php
declare(strict_types=1);
namespace PTS\Routing;

class RouteService
{

    public function makeRegExp(Route $route) : string
    {
        $regexp = $route->getPath();
        $restrictions = $route->getRestrictions();

        if (preg_match_all('~{(.*)}~Uu', $regexp, $placeholders)) {
            foreach ($placeholders[0] as $index => $match) {
                $name = $placeholders[1][$index];
                $replace = array_key_exists($name, $restrictions) ? $restrictions[$name] : '.*';
                $replace = '(?<'.$name.'>'.$replace.')';
                $regexp = str_replace($match, $replace, $regexp);
            }
        }

        return $regexp;
    }
}
