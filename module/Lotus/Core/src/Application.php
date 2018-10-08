<?php
declare(strict_types=1);

namespace Lotus\Core;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;
use Lotus\Core\Infrastructure\DI\Container;
use Lotus\Core\Infrastructure\DI\ContainerBuilder;
use Lotus\Core\Infrastructure\Http\Server\RequestHandler;
use Lotus\Core\Application\Http\Middleware\ResponseFactoryMiddleware;

class Application
{
    /**
     * @var Container
     */
    protected $container;

    public function run(): void
    {
        try {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->addDefinitions([
                ServerRequestInterface::class => ServerRequestFactory::fromGlobals(),
                RequestHandler::class => \DI\create(RequestHandler::class)->constructor([\DI\get(ResponseFactoryMiddleware::class)])
            ]);
            $this->container = $containerBuilder->build();

            $request = $this->container->get(ServerRequestInterface::class);
            $requestHandler = $this->container->get(RequestHandler::class);
            $response = $requestHandler->handle($request);

            echo $response->getBody();
        } catch (\Exception $e) {

        }
    }
}
