<?php

namespace App\Repository\Geo;

use App\Interfaces\Geo\GeoSearchInterface;
use Illuminate\Support\Facades\Redis;

class RedisGeoSearchRepository implements GeoSearchInterface {
    private const GEO_KEY = 'encontreumjiujiteiro-database-geo:training-locals';

    public function add(
        string $member,
        float $longitude,
        float $latitude
    ): bool {
        return (int) Redis::command('GEOADD', [
            self::GEO_KEY,
            $longitude,
            $latitude,
            $member,
        ]) >= 0;
    }

    public function remove(string $member): bool {
        return (int) Redis::command('ZREM', [
            self::GEO_KEY,
            $member,
        ]) > 0;
    }

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
    ): array {
        $results = Redis::command('GEOSEARCH', [
            self::GEO_KEY,
            'FROMLONLAT',
            $longitude,
            $latitude,
            'BYRADIUS',
            $radiusKm,
            'km',
            'WITHDIST',
            'ASC',
        ]);

        $locations = [];

        foreach ($results as $result) {
            $locations[] = [
                'member' => (string) $result[0],
                'distance_km' => (float) $result[1],
            ];
        }

        return $locations;
    }
}
