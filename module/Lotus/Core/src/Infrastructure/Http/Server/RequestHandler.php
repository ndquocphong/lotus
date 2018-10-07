<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $middlewares;

    /**
     * RequestHandler constructor.
     * @param array $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        foreach ($middlewares as $middleware) {
            if (!$middleware instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('$middlewares must be array of MiddlewareInterface');
            }
        }
        $this->middlewares = $middlewares;
    }

    /**
     * {@inheritdoc}
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = current($this->middlewares);
        next($this->middlewares);

        return $middleware->process($request, $this);
    }
}
