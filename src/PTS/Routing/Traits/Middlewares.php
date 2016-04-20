<?php
namespace PTS\Routing\Traits;

use Guzzle\Http\Message\RequestInterface;

trait Middlewares
{
    /** @var callable[] */
    protected $middlewares;
    
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
    public function __invoke(RequestInterface $request)
    {
        if (count($this->middlewares) === 0) {
            return null;
        }
        
        $middleware = array_shift($this->middlewares);
        return $middleware(... [$request, $this]);
    }

}
