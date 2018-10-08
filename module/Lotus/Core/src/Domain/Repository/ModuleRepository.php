<?php
declare(strict_types=1);

namespace Lotus\Core\Domain\Repository;

use Lotus\Core\Infrastructure\Data\ModuleDataTrait;
use Lotus\Core\Domain\Model\Module;
use Lotus\Core\Infrastructure\Database\DML\ColumnWhereDML;
use Lotus\Core\Infrastructure\Database\RepositoryInterface;

class ModuleRepository implements RepositoryInterface
{
    use ModuleDataTrait;

    /**
     * {@inheritdoc}
     *
     * @param array $dmls
     * @return Module[]
     */
    public function findBy(array $dmls)
    {
        $result = $this->data;
        foreach ($dmls as $dml) {
            if ($dml instanceof ColumnWhereDML) {
                foreach ($result as $k => $row) {
                    if (!isset($row[$dml->column])) {
                        throw new \InvalidArgumentException("{$dml->column} column was not found");
                    }
                    if ($row[$dml->column] != $dml->value) {
                        unset($result[$k]);
                    }
                }
            }
        }

        foreach ($result as $k => $row) {
            $module = new Module();
            $module->setId($row['id']);
            $module->setName($row['name']);
            $module->setDescription($row['description']);
            $module->setVersion($row['version']);
            $module->setStatus($row['status']);

            $result[$k] = $module;
        }

        return $result;
    }

    public function findOneBy()
    {

    }
}
