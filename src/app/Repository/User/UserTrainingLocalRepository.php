<?php

namespace App\Repository\User;

use App\DTOs\User\CreateTrainingLocalDTO;
use App\Models\User\UserModel;
use App\Models\User\UserTrainingLocal;

class UserTrainingLocalRepository {
    public function createTrainingLocal(
        UserModel $user,
        CreateTrainingLocalDTO $trainingLocal
    ): UserTrainingLocal {
        return $user->trainingLocals()->create([
            'name' => $trainingLocal->getName(),
            'address' => $trainingLocal->getAddress(),
            'number' => $trainingLocal->getNumber(),
            'complement' => $trainingLocal->getComplement(),
            'neighborhood' => $trainingLocal->getNeighborhood(),
            'city' => $trainingLocal->getCity(),
            'state' => $trainingLocal->getState(),
            'country' => $trainingLocal->getCountry(),
            'postal_code' => $trainingLocal->getPostalCode(),
            'latitude' => $trainingLocal->getLatitude(),
            'longitude' => $trainingLocal->getLongitude(),
        ]);
    }
}
