<?php

namespace App\Providers;

use App\Interfaces\Cache\CacheInterface;
use App\Models\User\UserAthleticProfile;
use App\Models\User\UserTrainingLocal;
use App\Observers\User\UserAthleticProfileObserver;
use App\Observers\User\UserTrainingLocalObserver;
use App\Repository\Cache\RedisCacheRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(
            CacheInterface::class,
            RedisCacheRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        UserAthleticProfile::observe(UserAthleticProfileObserver::class);
        UserTrainingLocal::observe(UserTrainingLocalObserver::class);
    }
}
