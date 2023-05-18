<?php

namespace App\Domains\Customer\Repositories;

use App\Common\Repositories\AbstractCommandRepository;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Models\Customer;

class CustomerCommandRepository extends AbstractCommandRepository implements CustomerCommandRepositoryContract
{
    public function model(): string
    {
        return Customer::class;
    }
}
