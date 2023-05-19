<?php

namespace App\Common\CQRSContracts;

interface AbstractQueryRepositoryInterface
{
    public function firstOrFailed(int $id): mixed;

    public function firstWhere(array $where, array $columns = ['*']): mixed;

    public function findWhere(array $where, array $columns = ['*']): mixed;
}