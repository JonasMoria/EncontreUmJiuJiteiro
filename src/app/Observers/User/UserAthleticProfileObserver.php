<?php

namespace App\Observers\User;

use App\Jobs\Cache\RefreshUserProfileCacheJob;
use App\Models\User\UserAthleticProfile;

class UserAthleticProfileObserver {
    public function created(UserAthleticProfile $profile): void {
        $this->dispatchCacheRefresh($profile);
    }

    public function updated(UserAthleticProfile $profile): void {
        $this->dispatchCacheRefresh($profile);
    }

    private function dispatchCacheRefresh(
        UserAthleticProfile $profile
    ): void {
        RefreshUserProfileCacheJob::dispatch($profile->user_id)
            ->afterCommit();
    }
}
