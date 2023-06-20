<?php

namespace App\Rules;

use App\Models\Terminal;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\PotentiallyTranslatedString;

class CurrentPin implements ValidationRule
{
    public function __construct(public Terminal $terminal)
    {}

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $attribute = str($attribute)->after('current_');
        $msg = 'The :attribute is incorrect.';

        $current_value = $this->terminal->{$attribute};

        if ( $current_value == '0000') {
            if ($value != $current_value) $fail($msg);
        }
        elseif (! Hash::check($value, $this->terminal->{$attribute})) {
            if ($attribute == 'pin') {
                $this->terminal->wrong_pin_count++;
                $this->terminal->withoutApproval()->save();

                if ($this->terminal->wrong_pin_count === 4) {
                    $msg = 'You entered the wrong pin 4 times. This terminal has been deactivated.';
                    $this->terminal->status = 'INACTIVE';
                    $this->terminal->withoutApproval()->save();
                }
            }

            $fail($msg);
        }
        else {
            // Reset wrong pin count if pin passes check
            if ($this->terminal->wrong_pin_count > 0) {
                $this->terminal->wrong_pin_count = 0;
                $this->terminal->withoutApproval()->save();
            }
        }
    }
}
