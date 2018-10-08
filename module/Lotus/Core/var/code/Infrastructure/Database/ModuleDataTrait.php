<?php
namespace Lotus\Core\Infrastructure\Database;

use Lotus\Core\Domain\Model\Module;

trait ModuleDataTrait
{
    protected $data = [
        'lotus/core' => [
            'id' => 'lotus/core',
            'name' => 'Lotus Core Module',
            'description' => 'Lotus Core Module',
            'version' => '1.0.0',
            'status' => Module::STATUS_INSTALLED
        ]
    ];
}
