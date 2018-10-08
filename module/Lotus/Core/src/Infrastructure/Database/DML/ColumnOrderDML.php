<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Database\DML;

use Doctrine\ORM\QueryBuilder;
use Lotus\Core\Infrastructure\Database\DMLInterface;

class ColumnOrderDML implements DMLInterface
{
    /**
     * @var string
     */
    public $orderBy;

    /**
     * @var string
     */
    public $direction;

    /**
     * ColumnOrderDML constructor.
     * @param $orderBy
     * @param $direction
     */
    public function __construct($orderBy, $direction)
    {
        $this->orderBy = $orderBy;
        $this->direction = $direction;
    }

    /**
     * @param QueryBuilder $query
     * @return DMLInterface
     */
    public function apply(QueryBuilder $query)
    {
        $query->addOrderBy($this->orderBy, $this->direction);
        return $this;
    }
}
