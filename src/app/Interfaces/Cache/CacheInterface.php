<?php

namespace App\Interfaces\Cache;

interface CacheInterface {
    public function save(
        string $key,
        array $data,
        ?int $ttl = null
    ): bool;

    public function find(string $key): ?array;

    public function update(string $key, array $data): bool;

    public function delete(string $key): bool;

    public function exists(string $key): bool;
}
