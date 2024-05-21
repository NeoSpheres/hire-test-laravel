<?php

namespace App\Rule;

use Illuminate\Contracts\Validation\Rule;

class MatriculeFrance implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^\w{1,2}-\d{3}-\w{2}$|^\d{1,4}\s\w{1,2}\s\d{2}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le format de la plaque d\'immatriculation française n\'est pas valide.';
    }
}
