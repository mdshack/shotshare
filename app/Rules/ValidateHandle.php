<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateHandle implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $message = "The $attribute field must only contain letters, numbers, dashes, periods, and underscores.";

        if (! is_string($value) && ! is_numeric($value)) {
            $fail($message);
        }

        if (isset($parameters[0]) && $parameters[0] === 'ascii' && preg_match('/\A[a-zA-Z0-9_-]+\z/u', $value) < 1) {
            $fail($message);
        }

        if(preg_match('/\A[.a-zA-Z0-9_-]+\z/u', $value) < 1) {
            $fail($message);
        }

        if(strlen($value) < 3) {
            $fail("The $attribute field must be at least 3 characters.");
        }
    }
}
