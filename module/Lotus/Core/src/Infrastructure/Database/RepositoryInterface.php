<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Database;

interface RepositoryInterface
{
    /**
     * @param array $dmls
     * @return mixed
     */
    public function findBy(array $dmls);
}
