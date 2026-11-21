<?php

namespace Database\Factories\User;

use App\Models\User\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<UserModel>
 */
class UserModelFactory extends Factory {
    private static ?string $passwordHash = null;
    protected $model = UserModel::class;

    public function definition(): array {
        return [
           'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => self::$passwordHash ??= Hash::make('password'),
            'remember_token' => null,
        ];
    }
}
