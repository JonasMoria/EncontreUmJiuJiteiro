<?php

namespace App\Services\User;

use App\DTOs\User\CreateUserDTO;
use App\Repository\User\UserRepository;

class UserService {
    private UserRepository $userRepository;

    public function __construct(
        ?UserRepository $userRepository = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    public function createUserAccount(CreateUserDTO $userDTO): array {
        $user = $this->userRepository->create(
            $userDTO
        );

        return [
            'id' => $user->id,
        ];
    }
}
