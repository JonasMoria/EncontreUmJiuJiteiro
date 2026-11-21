<?php

namespace App\Services\User;

use App\DTOs\User\CreateTrainingLocalDTO;
use App\Models\User\UserModel;
use App\Repository\User\UserTrainingLocalRepository;

class UserTrainingLocalService {
    private UserTrainingLocalRepository $userTrainingLocalRepository;

    public function __construct(
        ?UserTrainingLocalRepository $userTrainingLocalRepository = null,
    ) {
        $this->userTrainingLocalRepository = $userTrainingLocalRepository ?? new UserTrainingLocalRepository();
    }

    public function createUserTrainingLocal(
        UserModel $user,
        CreateTrainingLocalDTO $trainingLocal
    ): array {
        $userTrainingLocal = $this->userTrainingLocalRepository->createTrainingLocal(
            $user,
            $trainingLocal
        );

        return [
            'user_id' => $user->id,
            'profile_id' => $userTrainingLocal->id,
        ];
    }
}
