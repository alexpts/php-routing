<?php
declare(strict_types = 1);

namespace PTS\Routing\Traits;

use Psr\Http\Message\RequestInterface;

trait MiddlewaresTrait
{
    /** @var callable[] */
    protected $middlewares = [];


    public function pushMiddleware(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @return \callable[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    protected function invoke(RequestInterface $request)
    {
        $middleware = array_shift($this->middlewares);
        return $middleware(... [$request, $this]);
    }

}
