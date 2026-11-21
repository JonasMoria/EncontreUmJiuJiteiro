<?php

namespace Database\Seeders;

use App\Models\User\UserModel;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    private const USERS_QUANTITY = 20;

    public function run(): void {
        UserModel::factory(self::USERS_QUANTITY)
            ->create();
    }
}
