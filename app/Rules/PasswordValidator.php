<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\iLookupService;
use App\Services\Admin\LookupService;

class PasswordValidator implements Rule
{
    //protected $lookupService;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = trim($value);
        $lookupService = new LookupService();
        if(!is_string($value)) return false;

        $passwordLength = $lookupService->getByKey('PASSWORD_LENGTH');

        if($passwordLength)
        {
            if(strlen($value) < $passwordLength->value) return false;
        }
        else
        {
            if(strlen($value) < 6) return false;
        }

        $passwordComplexity = $lookupService->getByKey('PASSWORD_COMPLEXITY');

        if($passwordComplexity)
        {
            if(preg_match($passwordComplexity->value,$value) == 0) return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('passwords.password');
    }
}
