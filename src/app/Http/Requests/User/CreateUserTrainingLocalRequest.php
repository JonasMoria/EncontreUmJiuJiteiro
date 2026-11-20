<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AppFormRequest;

class CreateUserTrainingLocalRequest extends AppFormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
            'number' => [
                'nullable',
                'string',
                'max:20',
            ],
            'complement' => [
                'nullable',
                'string',
                'max:255',
            ],
            'neighborhood' => [
                'nullable',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'state' => [
                'required',
                'string',
                'max:100',
            ],
            'country' => [
                'required',
                'string',
                'max:100',
            ],
            'postal_code' => [
                'required',
                'string',
                'max:20',
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'FORM.TRAINING_LOCAL.NAME.REQUIRED',
            'name.string' => 'FORM.TRAINING_LOCAL.NAME.STRING',
            'name.max' => 'FORM.TRAINING_LOCAL.NAME.MAX',

            'address.required' => 'FORM.TRAINING_LOCAL.ADDRESS.REQUIRED',
            'address.string' => 'FORM.TRAINING_LOCAL.ADDRESS.STRING',
            'address.max' => 'FORM.TRAINING_LOCAL.ADDRESS.MAX',

            'number.string' => 'FORM.TRAINING_LOCAL.NUMBER.STRING',
            'number.max' => 'FORM.TRAINING_LOCAL.NUMBER.MAX',

            'complement.string' => 'FORM.TRAINING_LOCAL.COMPLEMENT.STRING',
            'complement.max' => 'FORM.TRAINING_LOCAL.COMPLEMENT.MAX',

            'neighborhood.string' => 'FORM.TRAINING_LOCAL.NEIGHBORHOOD.STRING',
            'neighborhood.max' => 'FORM.TRAINING_LOCAL.NEIGHBORHOOD.MAX',

            'city.required' => 'FORM.TRAINING_LOCAL.CITY.REQUIRED',
            'city.string' => 'FORM.TRAINING_LOCAL.CITY.STRING',
            'city.max' => 'FORM.TRAINING_LOCAL.CITY.MAX',

            'state.required' => 'FORM.TRAINING_LOCAL.STATE.REQUIRED',
            'state.string' => 'FORM.TRAINING_LOCAL.STATE.STRING',
            'state.max' => 'FORM.TRAINING_LOCAL.STATE.MAX',

            'country.required' => 'FORM.TRAINING_LOCAL.COUNTRY.REQUIRED',
            'country.string' => 'FORM.TRAINING_LOCAL.COUNTRY.STRING',
            'country.max' => 'FORM.TRAINING_LOCAL.COUNTRY.MAX',

            'postal_code.required' => 'FORM.TRAINING_LOCAL.POSTAL_CODE.REQUIRED',
            'postal_code.string' => 'FORM.TRAINING_LOCAL.POSTAL_CODE.STRING',
            'postal_code.max' => 'FORM.TRAINING_LOCAL.POSTAL_CODE.MAX',

            'latitude.required' => 'FORM.TRAINING_LOCAL.LATITUDE.REQUIRED',
            'latitude.numeric' => 'FORM.TRAINING_LOCAL.LATITUDE.NUMERIC',
            'latitude.between' => 'FORM.TRAINING_LOCAL.LATITUDE.BETWEEN',

            'longitude.required' => 'FORM.TRAINING_LOCAL.LONGITUDE.REQUIRED',
            'longitude.numeric' => 'FORM.TRAINING_LOCAL.LONGITUDE.NUMERIC',
            'longitude.between' => 'FORM.TRAINING_LOCAL.LONGITUDE.BETWEEN',
        ];
    }
}
