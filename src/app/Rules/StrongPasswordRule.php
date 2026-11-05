<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPasswordRule implements ValidationRule {
    /**
     * A senha deve possuir no mínimo 8 caracteres, incluindo letra maiúscula,
     * letra minúscula, número e caractere especial, sem espaços.
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (!is_string($value)) {
            $fail('A senha deve ser uma string.');
            return;
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])\S{8,}$/';

        if (!preg_match($pattern, $value)) {
            $fail('FORM.USER.PASSWORD.STRONG');
        }
    }
}
