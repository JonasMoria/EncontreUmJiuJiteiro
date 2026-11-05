<?php

namespace App\Http\Requests\User;

use App\Rules\StrongPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                new StrongPasswordRule(),
            ],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'FORM.CLIENT.NAME.REQUIRED',
            'name.string' => 'FORM.CLIENT.NAME.STRING',
            'name.min' => 'FORM.USER.NAME.MIN',
            'name.max' => 'FORM.CLIENT.NAME.MAX',
            'email.email' => 'FORM.CLIENT.EMAIL.INVALID',
            'email.max' => 'FORM.CLIENT.EMAIL.MAX',
            'password.required' => 'FORM.USER.PASSWORD.REQUIRED',
            'password.string' => 'FORM.USER.PASSWORD.STRING',
        ];
    }
}
