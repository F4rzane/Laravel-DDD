<?php

namespace App\Common\CQRSContracts;

interface AbstractCommandRepositoryInterface
{
    public function create(array $attributes): mixed;
    public function update(array $attributes, int $id): mixed;
}
