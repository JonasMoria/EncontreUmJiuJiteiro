<?php

namespace App\Enums;

enum AgeCategory: int {
    // Kids
    case MIGHTY_MITE_I = 1;
    case MIGHTY_MITE_II = 2;
    case MIGHTY_MITE_III = 3;

    case PEE_WEE_I = 4;
    case PEE_WEE_II = 5;
    case PEE_WEE_III = 6;

    case JUNIOR_I = 7;
    case JUNIOR_II = 8;
    case JUNIOR_III = 9;

    case TEEN_I = 10;
    case TEEN_II = 11;
    case TEEN_III = 12;

    // Juvenile
    case JUVENILE_I = 13;
    case JUVENILE_II = 14;

    // Adult
    case ADULT = 15;

    // Masters
    case MASTER_I = 16;
    case MASTER_II = 17;
    case MASTER_III = 18;
    case MASTER_IV = 19;
    case MASTER_V = 20;
    case MASTER_VI = 21;
    case MASTER_VII = 22;

    public function label(): string {
        return match ($this) {
            self::MIGHTY_MITE_I => 'Mirim I',
            self::MIGHTY_MITE_II => 'Mirim II',
            self::MIGHTY_MITE_III => 'Mirim III',

            self::PEE_WEE_I => 'Infantil I',
            self::PEE_WEE_II => 'Infantil II',
            self::PEE_WEE_III => 'Infantil III',

            self::JUNIOR_I => 'Infantojuvenil I',
            self::JUNIOR_II => 'Infantojuvenil II',
            self::JUNIOR_III => 'Infantojuvenil III',

            self::TEEN_I => 'Juvenil I',
            self::TEEN_II => 'Juvenil II',
            self::TEEN_III => 'Juvenil III',

            self::JUVENILE_I => 'Juvenil A',
            self::JUVENILE_II => 'Juvenil B',

            self::ADULT => 'Adulto',

            self::MASTER_I => 'Master 1',
            self::MASTER_II => 'Master 2',
            self::MASTER_III => 'Master 3',
            self::MASTER_IV => 'Master 4',
            self::MASTER_V => 'Master 5',
            self::MASTER_VI => 'Master 6',
            self::MASTER_VII => 'Master 7',
        };
    }
}
