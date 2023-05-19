<?php

namespace App\Domains\Customer\Repositories;

use App\Common\CQRSRepositories\AbstractQueryRepository;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\Models\Customer;

class CustomerQueryRepository extends AbstractQueryRepository implements CustomerQueryRepositoryContract
{
    public function model(): string
    {
        return Customer::class;
    }
}
