<?php
namespace PTS\Routing\Traits;

use Psr\Http\Message\RequestInterface;

trait MiddlewaresTrait
{
    /** @var callable[] */
    protected $middlewares = [];
    
    /**
     * @param callable $middleware
     * @return $this
     */
    public function pushMiddleware(callable $middleware)
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @return \callable[]
     */
    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }
    
    /**
     * @param RequestInterface $request
     * @return mixed
     */
    protected function invoke(RequestInterface $request) {
        $middleware = array_shift($this->middlewares);
        return $middleware(... [$request, $this]);
    }

}
