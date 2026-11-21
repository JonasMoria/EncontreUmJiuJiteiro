<?php

namespace App\Mappers\Cache;

use App\Collections\User\UserTrainingLocalCollection;
use App\Models\User\UserAthleticProfile;
use App\Models\User\UserModel;
use App\Models\User\UserTrainingLocal;

final class UserProfileCacheMapper {
    /**
     * @return array{
     *     athlete: array<string, mixed>,
     *     training_locals: array<int, array<string, mixed>>
     * }
     */
    public static function createPayload(
        UserModel $user,
        UserAthleticProfile $userAthleticProfile,
        UserTrainingLocalCollection $userTrainingLocals
    ): array {
        $trainingLocals = [];

        foreach ($userTrainingLocals as $local) {
            $trainingLocals[] = self::mapTrainingLocal($local);
        }

        return [
            'athlete' => self::mapAthlete($user, $userAthleticProfile),
            'training_locals' => $trainingLocals,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function mapAthlete(
        UserModel $user,
        UserAthleticProfile $athleticProfile
    ): array {
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'birthdate' => $athleticProfile->birthdate,
            'gender' => $athleticProfile->gender,
            'belt_category' => $athleticProfile->belt_category,
            'weight' => $athleticProfile->weight_kg,
            'weight_category' => $athleticProfile->weight_category,
            'profile_photo_path' => $athleticProfile->avatar_path,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function mapTrainingLocal(
        UserTrainingLocal $trainingLocal
    ): array {
        return [
            'id' => $trainingLocal->id,
            'name' => $trainingLocal->name,
            'address' => $trainingLocal->address,
            'number' => $trainingLocal->number,
            'complement' => $trainingLocal->complement,
            'neighborhood' => $trainingLocal->neighborhood,
            'city' => $trainingLocal->city,
            'state' => $trainingLocal->state,
            'country' => $trainingLocal->country,
            'postal_code' => $trainingLocal->postalCode,
            'latitude' => $trainingLocal->latitude,
            'longitude' => $trainingLocal->longitude,
        ];
    }
}
