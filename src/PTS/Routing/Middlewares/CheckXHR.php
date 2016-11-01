<?php
declare(strict_types=1);
namespace PTS\Routing\Middlewares;

use Psr\Http\Message\RequestInterface;

class CheckXHR
{
    const ONLY_XHR = 1;
    const ONLY_NO_XHR = 2;

    protected $state;

    /**
     * CheckXHR constructor.
     * @param int $state
     */
    public function __construct(int $state = self::ONLY_XHR)
    {
        $this->state = $state;
    }

    /**
     * @param RequestInterface $request
     * @param callable $next
     * @return mixed
     */
    public function __invoke(RequestInterface $request, callable $next)
    {
        $isXHR = in_array('XMLHttpRequest', $request->getHeader('X-Requested-With'), true);

        switch ($this->state) {
            case self::ONLY_XHR:
                if (!$isXHR) { return null; }
                break;
            case self::ONLY_NO_XHR:
                if ($isXHR) { return null; }
                break;

        }

        return $next($request);
    }
}
