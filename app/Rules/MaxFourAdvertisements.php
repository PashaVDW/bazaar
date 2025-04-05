<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class MaxFourAdvertisements implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user();

        if ($user->advertisements()->count() >= 4) {
            $fail('You can only create a maximum of 4 advertisements.');
        }
    }
}
