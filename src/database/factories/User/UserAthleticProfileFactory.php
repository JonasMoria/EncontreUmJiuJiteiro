<?php

namespace Database\Factories\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use App\Models\User\UserAthleticProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAthleticProfile>
 */
class UserAthleticProfileFactory extends Factory {
    protected $model = UserAthleticProfile::class;

    public function definition(): array {
        return [
            'birthdate' => fake()->dateTimeBetween('-50 years', '-18 years'),
            'gender' => fake()->randomElement(Gender::cases()),
            'belt_category' => fake()->randomElement([
                BeltCategory::WHITE,
                BeltCategory::BLUE,
                BeltCategory::PURPLE,
                BeltCategory::BROWN,
                BeltCategory::BLACK,
            ]),
            'weight_category' => fake()->randomElement(
                WeightCategory::cases()
            ),
            'weight_kg' => fake()->randomFloat(2, 50, 120),
            'avatar_path' => null,
        ];
    }
}
