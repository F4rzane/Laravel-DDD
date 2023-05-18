<?php

namespace App\Domains\Customer\Rules;

use App\SharedKernel\Contracts\Domains\AssistantDomainContract;
use Illuminate\Contracts\Validation\Rule;

class ValidatePhone implements Rule
{
    /**
     * Create a new in rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            if($phoneUtil->isPossibleNumber($value)){
                return true;
            }

            return false;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'invalid phone number';
    }
}
