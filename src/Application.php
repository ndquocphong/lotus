<?php
declare(strict_types=1);

namespace Lotus;

use Lotus\Infrastructure\DI\ContainerBuilder;
use Lotus\Infrastructure\DI\Container;
use Lotus\Infrastructure\Http\Server\RequestHandler;
use Lotus\Infrastructure\Http\Server\ResponseHandlerMiddleware;
use Zend\Diactoros\ServerRequestFactory;

class Application
{
    protected $initialized = false;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @throws \Exception
     */
    protected function initializeDIContainer()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            RequestHandler::class => \DI\create(RequestHandler::class)->constructor([\DI\get(ResponseHandlerMiddleware::class)])
        ]);
        $this->container = $builder->build();
    }

    /**
     * @throws \Exception
     */
    public function initialize(): void
    {
        $this->initializeDIContainer();
        // di build
        $this->initialized = true;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        $requestHandler = $this->container->get(RequestHandler::class);

        $response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

        echo $response->getBody();
    }
}