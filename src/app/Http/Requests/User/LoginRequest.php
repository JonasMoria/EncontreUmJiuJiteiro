<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AppFormRequest;

class LoginRequest extends AppFormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages() {
        return [
            'email.required' => 'FORM.CLIENT.EMAIL.REQUIRED',
            'email.email' => 'FORM.CLIENT.EMAIL.INVALID',
            'password.required' => 'FORM.USER.PASSWORD.REQUIRED',
            'password.string' => 'FORM.USER.PASSWORD.STRING',
        ];
    }
}
