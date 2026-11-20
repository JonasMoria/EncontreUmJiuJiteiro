<?php

namespace App\Repository\User;

use App\DTOs\User\CreateAthleticProfileDTO;
use App\Models\User\UserAthleticProfile;
use App\Models\User\UserModel;

class UserAthleticProfileRepository {
    public function createProfile(
        UserModel $user,
        CreateAthleticProfileDTO $profileDTO
    ): UserAthleticProfile {
        return $user->athleticProfile()->create([
            'birthdate' => $profileDTO->getBirthDate()->toDateString(),
            'gender' => $profileDTO->getGender()->value,
            'belt_category' => $profileDTO->getBeltCategory()->value,
            'weight_category' => $profileDTO->getWeightCategory()->value,
            'weight_kg' => $profileDTO->getWeight(),
        ]);
    }

    public function updateAvatarPath(UserModel $user, string $avatarPath): bool {
        $affectedRows = $user->athleticProfile()->update([
            'avatar_path' => $avatarPath,
        ]);

        return $affectedRows > 0;
    }
}
