<?php

namespace App\Jobs\Cache;

use App\Http\Exceptions\AppRuntimeException;
use App\Models\User\UserModel;
use App\Services\Cache\ProfileCacheManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshUserProfileCacheJob implements ShouldQueue {
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;

    public function __construct(
        public readonly int $userId
    ) {
    }

    public function handle(ProfileCacheManager $profileCacheManager): void {
        $user = UserModel::find($this->userId);
        if ($user === null) {
            return;
        }

        try {
            $profileCacheManager->saveProfile($user);
        } catch (AppRuntimeException $exception) {
            $skipJob = in_array($exception->getMessage(), [
               'USER.ATHLETIC.PROFILE.NOT.FOUND',
               'USER.TRAINING.LOCALS.NOT.FOUND',
            ]);

            if ($skipJob) {
                return;
            }

            throw $exception;
        }
    }

    public function backOff(): array {
        return [10, 30, 60];
    }
}
