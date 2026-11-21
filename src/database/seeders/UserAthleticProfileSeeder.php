<?php

namespace Database\Seeders;

use App\Models\User\UserModel;
use Database\Factories\User\UserAthleticProfileFactory;
use Illuminate\Database\Seeder;

class UserAthleticProfileSeeder extends Seeder {
    public function run(): void {
        UserModel::query()
            ->doesntHave('athleticProfile')
            ->each(function (UserModel $user): void {
                $user->athleticProfile()->create(
                    UserAthleticProfileFactory::new()
                        ->make()
                        ->getAttributes()
                );
            });
    }
}
