<?php
declare(strict_types=1);

namespace Lotus\Core;

use Composer\Autoload\ClassLoader;
use Lotus\Core\Domain\Model\Module;
use Lotus\Core\Domain\Repository\ModuleRepository;
use Lotus\Core\Infrastructure\Database\DML\ColumnWhereDML;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\ServerRequestFactory;
use Lotus\Core\Infrastructure\Event\Dispatcher as EventDispatcher;
use Lotus\Core\Domain\Event\DispatcherInterface as EventDispatcherInterface;
use Lotus\Core\Infrastructure\Event\Dispatcher;
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

    /**
     * @var MiddlewareInterface[]
     */
    protected $middlewares;

    /**
     * @var ClassLoader
     */
    protected $autoloader;

    /**
     * @var ModuleRepository
     */
    protected $moduleRepository;

    /**
     * @var Dispatcher
     */
    protected $eventDispatcher;

    /**
     * Application constructor.
     *
     * @param ClassLoader $classLoader
     */
    public function __construct(ClassLoader $classLoader)
    {
        $this->autoloader = $classLoader;
        $this->moduleRepository = new ModuleRepository();
        $this->eventDispatcher = new EventDispatcher();
    }

    /**
     * @return ClassLoader
     */
    public function getAutoloader(): ClassLoader
    {
        return $this->autoloader;
    }

    /**
     * Initialize DI container
     *
     * @throws \Exception
     */
    protected function initializeDIContainer(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            ServerRequestInterface::class => ServerRequestFactory::fromGlobals(),
            RequestHandler::class => \DI\create(RequestHandler::class)->constructor([\DI\get(ResponseFactoryMiddleware::class)]),
            ModuleRepository::class => $this->moduleRepository,
            EventDispatcherInterface::class => \DI\create(EventDispatcher::class)
        ]);
        $this->container = $containerBuilder->build();
    }

    /**
     * Initialize middleware
     */
    protected function initializeMiddleware(): void
    {
        $this->middlewares[] = $this->container->get(ResponseFactoryMiddleware::class);
    }

    /**
     * Boot application
     */
    protected function boot(): void
    {
        $enabledModules = $this->moduleRepository->findBy([
            new ColumnWhereDML('status', Module::STATUS_ENABLED),
        ]);
        foreach ($enabledModules as $module) {
            $module->boot($this);
        }

        $this->initializeDIContainer();
        $this->initializeMiddleware();
    }

    public function run(): void
    {
        $this->boot();

        $request = $this->container->get(ServerRequestInterface::class);
        $requestHandler = $this->container->get(RequestHandler::class);
        $response = $requestHandler->handle($request);

        echo $response->getBody();
    }
}
