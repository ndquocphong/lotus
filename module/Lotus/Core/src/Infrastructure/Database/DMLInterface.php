<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Database;

use Doctrine\ORM\QueryBuilder;

interface DMLInterface
{
    /**
     * @param QueryBuilder $query
     * @return DMLInterface
     */
    public function apply(QueryBuilder $query);
}
