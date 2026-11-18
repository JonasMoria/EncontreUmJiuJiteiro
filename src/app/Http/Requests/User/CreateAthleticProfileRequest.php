<?php

namespace App\Http\Requests\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAthleticProfileRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'gender' => [
                'required',
                Rule::enum(Gender::class),
            ],
            'belt_category' => [
                'required',
                Rule::enum(BeltCategory::class),
            ],
            'weight' => [
                'nullable',
                'numeric',
                'decimal:1,2',
                'min:1',
            ],
            'weight_category' => [
                'required',
                Rule::enum(WeightCategory::class),
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],
        ];
    }

    public function messages(): array {
        return [
            'birthdate.required' => 'FORM.USER.PROFILE.BIRTHDATE.REQUIRED',
            'birthdate.date' => 'FORM.USER.PROFILE.BIRTHDATE.INVALID',
            'birthdate.before_or_equal' => 'FORM.USER.PROFILE.BIRTHDATE.FUTURE',
            'gender.required' => 'FORM.USER.PROFILE.GENDER.REQUIRED',
            'gender.enum' => 'FORM.USER.PROFILE.GENDER.INVALID',
            'belt_category.required' => 'FORM.USER.PROFILE.BELT_CATEGORY.REQUIRED',
            'belt_category.enum' => 'FORM.USER.PROFILE.BELT_CATEGORY.INVALID',
            'weight.numeric' => 'FORM.USER.PROFILE.WEIGHT.INVALID',
            'weight.decimal' => 'FORM.USER.PROFILE.WEIGHT.VALUE.INVALID',
            'weight.min' => 'FORM.USER.PROFILE.WEIGHT.MIN.INVALID',
            'weight_category.required' => 'FORM.USER.PROFILE.WEIGHT_CATEGORY.REQUIRED',
            'weight_category.enum' => 'FORM.USER.PROFILE.WEIGHT_CATEGORY.INVALID',
            'avatar.image' => 'FORM.USER.PROFILE.AVATAR.IMAGE',
            'avatar.mimes' => 'FORM.USER.PROFILE.AVATAR.MIMES',
            'avatar.max' => 'FORM.USER.PROFILE.AVATAR.MAX',
        ];
    }
}
