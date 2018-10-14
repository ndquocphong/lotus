<?php
namespace Lotus\Core\Infrastructure\Data;

use Lotus\Core\Domain\Model\Module;

trait ModuleDataTrait
{
    protected $data = [
        'lotus/core' => [
            'id' => 'lotus/core',
            'path' => 'Lotus/Core',
            'name' => 'Lotus Core Module',
            'description' => 'Lotus Core Module',
            'version' => '1.0.0',
            'status' => Module::STATUS_ENABLED
        ],
        'lotus/dummy' => [
            'id' => 'lotus/dummy',
            'path' => 'Lotus/Dummy',
            'name' => 'Lotus Dummy Module',
            'description' => 'Lotus Dummy Module',
            'version' => '1.0.0',
            'status' => Module::STATUS_ENABLED
        ]
    ];
}
