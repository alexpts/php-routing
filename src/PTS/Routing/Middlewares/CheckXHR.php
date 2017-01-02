<?php
declare(strict_types = 1);
namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;

class CheckXHR
{
    const ONLY_XHR = 1;
    const ONLY_NO_XHR = 2;

    protected $state;

    public function __construct(int $state = self::ONLY_XHR)
    {
        $this->state = $state;
    }

    public function __invoke(RequestInterface $request, callable $next)
    {
        $isXHR = in_array('XMLHttpRequest', $request->getHeader('X-Requested-With'), true);

        if (!$isXHR && $this->state === self::ONLY_XHR) {
            return $this->state === self::ONLY_XHR ? null : $next($request);
        } elseif ($isXHR && $this->state === self::ONLY_NO_XHR) {
            return $this->state === self::ONLY_NO_XHR ? null : $next($request);
        }

        return $next($request);
    }
}
