<?php
declare(strict_types=1);

namespace Lotus\Core;

use Lotus\Core\Domain\Model\Module;
use Lotus\Core\Domain\Repository\ModuleRepository;
use Lotus\Core\Infrastructure\Database\DML\ColumnWhereDML;
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


            $enabledModules = $this->container->get(ModuleRepository::class)->findBy([
                new ColumnWhereDML('status', Module::STATUS_ENABLED),
            ]);
            foreach ($enabledModules as $module) {
                $module->sayHello();
            }

            $request = $this->container->get(ServerRequestInterface::class);
            $requestHandler = $this->container->get(RequestHandler::class);
            $response = $requestHandler->handle($request);

            echo $response->getBody();
        } catch (\Exception $e) {

        }
    }
}
