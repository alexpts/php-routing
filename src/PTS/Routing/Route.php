<?php
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

    /**
     * @param string $path
     * @param callable $handler
     */
    public function __construct(string $path, callable $handler)
    {
        $this->path = $path;
        $this->endPoint = new EndPoint($handler);
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function __invoke(RequestInterface $request)
    {
        if (count($this->getMiddlewares()) === 0) {
            $endPoint = $this->endPoint;
            return $endPoint();
        }

        return $this->invoke($request);
    }

    /**
     * @return EndPoint
     */
    public function getEndPoint() : EndPoint
    {
        return $this->endPoint;
    }

    /**
     * @param array $restrictions
     * @return $this
     */
    public function setRestrictions(array $restrictions)
    {
        $this->restrictions = $restrictions;
        return $this;
    }

    /**
     * @return array
     */
    public function getRestrictions() : array
    {
        return $this->restrictions;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setMatches(array $values = [])
    {
        $this->matches = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getMatches() : array
    {
        return $this->matches;
    }

    /**
     * @return array
     */
    public function getMethods() : array
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;
        return $this;
    }
}
