<?php

namespace App\Observers\User;

use App\Jobs\Cache\RefreshUserProfileCacheJob;
use App\Models\User\UserTrainingLocal;

class UserTrainingLocalObserver {
    public function created(UserTrainingLocal $trainingLocal): void {
        $this->dispatchCacheRefresh($trainingLocal);
    }

    public function updated(UserTrainingLocal $trainingLocal): void {
        $this->dispatchCacheRefresh($trainingLocal);
    }

    private function dispatchCacheRefresh(
        UserTrainingLocal $trainingLocal
    ): void {
        RefreshUserProfileCacheJob::dispatch($trainingLocal->user_id)
            ->afterCommit();
    }
}
