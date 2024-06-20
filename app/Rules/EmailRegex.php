<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailRegex implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $maxLength = 254; // Maximum length for an email address according to RFC 5321
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';

        if (strlen($value) > $maxLength || !preg_match($pattern, $value)) {
            $fail('The :attribute must be a valid email address with a maximum length of 254 characters, contain an "@" sign .');
        }
    }
}
