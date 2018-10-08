<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Database\DML;

use Doctrine\ORM\QueryBuilder;
use Lotus\Core\Infrastructure\Database\DMLInterface;

class ColumnWhereDML implements DMLInterface
{
    /**
     * @var string
     */
    public $column;

    /**
     * @var string
     */
    public $value;

    /**
     * ColumnWhereDML constructor.
     *
     * @param $column
     * @param $value
     */
    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @param QueryBuilder $query
     * @return DMLInterface
     */
    public function apply(QueryBuilder $query)
    {
        $query->where($this->column, $this->value);
        return $this;
    }
}
