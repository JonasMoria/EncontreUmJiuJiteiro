<?php

namespace App\Services\Cache;

use App\Collections\User\UserTrainingLocalCollection;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Interfaces\Cache\CacheInterface;
use App\Interfaces\Geo\GeoSearchInterface;
use App\Mappers\Cache\UserProfileCacheMapper;
use App\Models\User\UserAthleticProfile;
use App\Models\User\UserModel;
use App\Repository\Cache\RedisCacheRepository;
use App\Repository\Geo\RedisGeoSearchRepository;
use App\Repository\User\UserAthleticProfileRepository;
use App\Repository\User\UserTrainingLocalRepository;

class ProfileCacheManager {
    private UserAthleticProfileRepository $userAthleticProfileRepository;
    private UserTrainingLocalRepository $userTrainingLocalRepository;
    private CacheInterface $cacheManagerRepository;
    private GeoSearchInterface $geoSearchRepository;

    public function __construct(
        ?UserAthleticProfileRepository $userAthleticProfileRepository,
        ?UserTrainingLocalRepository $userTrainingLocalRepository,
        ?CacheInterface $cacheManagerRepository,
        ?GeoSearchInterface $geoSearchRepository
    ) {
        $this->userAthleticProfileRepository = $userAthleticProfileRepository ?? new UserAthleticProfileRepository();
        $this->userTrainingLocalRepository = $userTrainingLocalRepository ?? new UserTrainingLocalRepository();
        $this->cacheManagerRepository = $cacheManagerRepository ?? new RedisCacheRepository();
        $this->geoSearchRepository = $geoSearchRepository ?? new RedisGeoSearchRepository();
    }

    public function saveProfile(UserModel $user): bool {
        $athleticProfile = $this->getAthleticProfile($user);
        $trainingLocals = $this->getTrainingLocals($user);

        $key = $this->buildKey($user->id);
        $payload = UserProfileCacheMapper::createPayload(
            $user,
            $athleticProfile,
            $trainingLocals
        );

        $cached = $this->cacheManagerRepository->save(
            $key,
            $payload
        );

        if (!$cached) {
            return false;
        }

        $this->indexTrainingLocals($user->id, $trainingLocals);
        return true;
    }

    protected function getAthleticProfile(UserModel $user): UserAthleticProfile {
        $athleticProfile = $this->userAthleticProfileRepository->getProfile($user);
        if ($athleticProfile === null) {
            throw new AppRuntimeException(
                'USER.ATHLETIC.PROFILE.NOT.FOUND',
                HttpStatusCode::NOT_FOUND
            );
        }

        return $athleticProfile;
    }

    protected function getTrainingLocals(UserModel $user): UserTrainingLocalCollection {
        $locals = $this->userTrainingLocalRepository->getAll($user);
        if ($locals->isEmpty()) {
            throw new AppRuntimeException(
                'USER.TRAINING.LOCALS.NOT.FOUND',
                HttpStatusCode::NOT_FOUND
            );
        }

        return $locals;
    }

    protected function buildKey(int $userId): string {
        return "user:profile:{$userId}";
    }

    protected function indexTrainingLocals(
        int $userId,
        UserTrainingLocalCollection $trainingLocals
    ): void {
        foreach ($trainingLocals as $trainingLocal) {
            $member = sprintf(
                'user:%d:local:%d',
                $userId,
                $trainingLocal->id
            );

            $this->geoSearchRepository->add(
                $member,
                (float) $trainingLocal->longitude,
                (float) $trainingLocal->latitude
            );
        }
    }
}
