<?php

namespace App\Enums;

enum WeightCategory: int {
    case ROOSTER = 1;
    case LIGHT_FEATHER = 2;
    case FEATHER = 3;
    case LIGHT = 4;
    case MIDDLE = 5;
    case MEDIUM_HEAVY = 6;
    case HEAVY = 7;
    case SUPER_HEAVY = 8;
    case ULTRA_HEAVY = 9;

    case OPEN_CLASS = 10;

    public function label(): string {
        return match ($this) {
            self::ROOSTER => 'Galo',
            self::LIGHT_FEATHER => 'Pluma',
            self::FEATHER => 'Pena',
            self::LIGHT => 'Leve',
            self::MIDDLE => 'Médio',
            self::MEDIUM_HEAVY => 'Meio-Pesado',
            self::HEAVY => 'Pesado',
            self::SUPER_HEAVY => 'Superpesado',
            self::ULTRA_HEAVY => 'Pesadíssimo',
            self::OPEN_CLASS => 'Absoluto',
        };
    }
}
