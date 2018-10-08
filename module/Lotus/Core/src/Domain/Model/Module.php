<?php
declare(strict_types=1);
namespace Lotus\Core\Domain\Model;

use Lotus\Core\Infrastructure\Database\ORM\ModuleTrait;

class Module
{
    use ModuleTrait;

    const STATUS_INSTALLED = 0;

    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 2;
}
