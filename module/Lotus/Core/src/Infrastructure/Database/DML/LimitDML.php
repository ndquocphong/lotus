<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Database\DML;

use Doctrine\ORM\QueryBuilder;
use Lotus\Core\Infrastructure\Database\DMLInterface;

class LimitDML implements DMLInterface
{
    /**
     * @var
     */
    public $limit;

    /**
     * LimitDML constructor.
     * @param $limit
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     *
     * @param QueryBuilder $query
     * @return DMLInterface
     */
    public function apply(QueryBuilder $query)
    {
        $query->setMaxResults($this->limit);
        return $this;
    }
}
