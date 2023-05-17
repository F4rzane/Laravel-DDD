<?php

namespace App\Common\Contracts;

interface AbstractCommandRepositoryInterface
{
    public function create(array $attributes): mixed;
    public function update(array $attributes, int $id): mixed;
}
