<?php
declare(strict_types=1);

namespace Lotus\Core\Domain\Repository;

use Lotus\Core\Infrastructure\Database\ModuleDataTrait;
use Lotus\Core\Domain\Model\Module;

class ModuleRepository
{
    use ModuleDataTrait;

    /**
     * Find an module by id
     *
     * @param $id
     * @return Module
     */
    public function findById($id)
    {
        if (!isset($this->data[$id])) {
            return null;
        }

        $module = new Module();
        $module->setId($this->data[$id]['id']);
        $module->setName($this->data[$id]['name']);
        $module->setDescription($this->data[$id]['description']);
        $module->setVersion($this->data[$id]['version']);
        $module->setStatus($this->data[$id]['status']);

        return $module;
    }
}
