<?php

namespace App\Infrastructure\Domains\Repositories;

interface BaseRepositoryContract
{
    public function create(array $attributes): mixed;
    public function update(array $attributes, int $id): mixed;
}
