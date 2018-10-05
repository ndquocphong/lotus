<?php
declare(strict_types=1);

namespace Lotus\Infrastructure\DI;

class ContainerBuilder extends \DI\ContainerBuilder
{
    public function __construct(string $containerClass = 'Lotus\Infrastructure\DI\Container')
    {
        parent::__construct($containerClass);
    }
}
