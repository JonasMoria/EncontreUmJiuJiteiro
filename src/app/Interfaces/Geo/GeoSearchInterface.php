<?php

namespace App\Interfaces\Geo;

interface GeoSearchInterface {
    public function add(
        string $member,
        float $longitude,
        float $latitude
    ): bool;

    public function remove(string $member): bool;

    /**
     * @return array<int, array{
     *     member: string,
     *     distance_km: float
     * }>
     */
    public function searchNearby(
        float $longitude,
        float $latitude,
        float $radiusKm
    ): array;
}
