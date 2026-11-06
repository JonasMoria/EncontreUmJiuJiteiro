<?php

namespace App\Repository\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User\UserModel;

class UserRepository {
    public function create(
        CreateUserDTO $userDto
    ): UserModel {
        return UserModel::create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'password' => $userDto->getPassword(),
        ]);
    }
}
