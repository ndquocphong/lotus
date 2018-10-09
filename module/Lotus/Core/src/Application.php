<?php
declare(strict_types=1);

namespace Lotus\Core;

use Composer\Autoload\ClassLoader;
use Lotus\Bar\Bar;
use Lotus\Core\Domain\Model\Module;
use Lotus\Core\Domain\Repository\ModuleRepository;
use Lotus\Core\Infrastructure\Database\DML\ColumnWhereDML;
use Lotus\Foo\Foo;
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

    /**
     * @var ClassLoader
     */
    protected $autoloader;

    /**
     * @var ModuleRepository
     */
    protected $moduleRepository;

    /**
     * Application constructor.
     *
     * @param ClassLoader $classLoader
     */
    public function __construct(ClassLoader $classLoader)
    {
        $this->autoloader = $classLoader;
        $this->moduleRepository = new ModuleRepository();
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
            ModuleRepository::class => $this->moduleRepository
        ]);
        $this->container = $containerBuilder->build();
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
    }

    public function run(): void
    {
        $this->boot();

            $this->container->get(Foo::class)->sayHello();
            $this->container->get(Bar::class)->sayHello();

        $request = $this->container->get(ServerRequestInterface::class);
        $requestHandler = $this->container->get(RequestHandler::class);
        $response = $requestHandler->handle($request);

        echo $response->getBody();
    }
}
