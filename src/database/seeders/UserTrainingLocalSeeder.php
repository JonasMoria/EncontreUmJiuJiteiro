<?php

namespace Database\Seeders;

use App\Models\User\UserModel;
use Database\Factories\User\UserTrainingLocalFactory;
use Illuminate\Database\Seeder;

class UserTrainingLocalSeeder extends Seeder {
    private const MIN_LOCALS_PER_USER = 1;
    private const MAX_LOCALS_PER_USER = 3;

    public function run(): void {
        UserModel::query()
            ->with('trainingLocals')
            ->each(function (UserModel $user): void {
                // Não duplica locais se o Seeder for executado novamente.
                if ($user->trainingLocals->isNotEmpty()) {
                    return;
                }

                $quantity = fake()->numberBetween(
                    self::MIN_LOCALS_PER_USER,
                    self::MAX_LOCALS_PER_USER
                );

                for ($i = 0; $i < $quantity; $i++) {
                    $attributes = UserTrainingLocalFactory::new()
                        ->make()
                        ->getAttributes();

                    $user->trainingLocals()->create($attributes);
                }
            });
    }
}
