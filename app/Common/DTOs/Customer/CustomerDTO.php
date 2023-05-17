<?php

namespace App\Common\DTOs\Customer;

use Spatie\LaravelData\Data;

class CustomerDTO extends Data
{
    public function __construct(
        public int $id,
        public string $firstname,
        public string $lastname,
        public string $birth_date,
        public string $phone,
        public string $bank_account,
        public string $email,
    )
    {}
}
