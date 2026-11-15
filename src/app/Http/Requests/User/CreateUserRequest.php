<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AppFormRequest;
use App\Rules\StrongPasswordRule;
use Illuminate\Validation\Rule;

class CreateUserRequest extends AppFormRequest {
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
                Rule::unique('users', 'email'),
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
            'email.unique' => 'FORM.CLIENT.EMAIL.ALREADY.EXISTS',
            'password.required' => 'FORM.USER.PASSWORD.REQUIRED',
            'password.string' => 'FORM.USER.PASSWORD.STRING',
        ];
    }
}
