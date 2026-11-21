<?php

namespace App\Repository\Cache;

use App\Interfaces\Cache\CacheInterface;
use Illuminate\Support\Facades\Redis;

class RedisCacheRepository implements CacheInterface {
    public function save(
        string $key,
        array $data,
        ?int $ttl = null
    ): bool {
        $value = json_encode($data, JSON_THROW_ON_ERROR);

        if ($ttl !== null) {
            return (bool) Redis::setex($key, $ttl, $value);
        }

        return (bool) Redis::set($key, $value);
    }

    public function find(string $key): ?array {
        $value = Redis::get($key);

        if ($value === null) {
            return null;
        }

        return json_decode(
            $value,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function update(string $key, array $data): bool {
        if (!$this->exists($key)) {
            return false;
        }

        $value = json_encode($data, JSON_THROW_ON_ERROR);

        return (bool) Redis::set($key, $value);
    }

    public function delete(string $key): bool {
        return Redis::del($key) > 0;
    }

    public function exists(string $key): bool {
        return Redis::exists($key) > 0;
    }
}
