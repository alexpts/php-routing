<?php
declare(strict_types=1);
namespace PTS\Routing;

use Psr\Http\Message\RequestInterface;
use PTS\Routing\Traits\MiddlewaresTrait;

class Route
{
    use MiddlewaresTrait;

    /** @var string */
    protected $path;
    /** @var callable */
    protected $endPoint;
    /** @var array */
    protected $methods = [];
    /** @var array */
    protected $restrictions = [];
    /** @var array */
    protected $matches = [];

    public function __construct(string $path, callable $handler)
    {
        $this->path = $path;
        $this->endPoint = new EndPoint($handler);
    }

    public function __invoke(RequestInterface $request)
    {
        if (count($this->getMiddlewares()) === 0) {
            return ($this->endPoint)();
        }

        return $this->invoke($request);
    }

    public function getEndPoint() : EndPoint
    {
        return $this->endPoint;
    }

    public function setRestrictions(array $restrictions)
    {
        $this->restrictions = $restrictions;
        return $this;
    }

    public function getRestrictions() : array
    {
        return $this->restrictions;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function setMatches(array $values = [])
    {
        $this->matches = $values;
        return $this;
    }

    public function getMatches() : array
    {
        return $this->matches;
    }

    public function getMethods() : array
    {
        return $this->methods;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;
        return $this;
    }
}
