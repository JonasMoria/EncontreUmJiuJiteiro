<?php

namespace App\Enums;

enum BeltCategory: int {
    // Kids - Grey Group
    case GREY_WHITE = 1;
    case GREY = 2;
    case GREY_BLACK = 3;

    // Kids - Yellow Group
    case YELLOW_WHITE = 4;
    case YELLOW = 5;
    case YELLOW_BLACK = 6;

    // Kids - Orange Group
    case ORANGE_WHITE = 7;
    case ORANGE = 8;
    case ORANGE_BLACK = 9;

    // Kids - Green Group
    case GREEN_WHITE = 10;
    case GREEN = 11;
    case GREEN_BLACK = 12;

    // Adult and Juvenile
    case WHITE = 13;
    case BLUE = 14;
    case PURPLE = 15;
    case BROWN = 16;
    case BLACK = 17;

    // Higher degrees
    case RED_BLACK = 18;
    case RED_WHITE = 19;
    case RED = 20;

    public function label(): string {
        return match ($this) {
            self::GREY_WHITE => 'Cinza e Branca',
            self::GREY => 'Cinza',
            self::GREY_BLACK => 'Cinza e Preta',

            self::YELLOW_WHITE => 'Amarela e Branca',
            self::YELLOW => 'Amarela',
            self::YELLOW_BLACK => 'Amarela e Preta',

            self::ORANGE_WHITE => 'Laranja e Branca',
            self::ORANGE => 'Laranja',
            self::ORANGE_BLACK => 'Laranja e Preta',

            self::GREEN_WHITE => 'Verde e Branca',
            self::GREEN => 'Verde',
            self::GREEN_BLACK => 'Verde e Preta',

            self::WHITE => 'Branca',
            self::BLUE => 'Azul',
            self::PURPLE => 'Roxa',
            self::BROWN => 'Marrom',
            self::BLACK => 'Preta',

            self::RED_BLACK => 'Vermelha e Preta',
            self::RED_WHITE => 'Vermelha e Branca',
            self::RED => 'Vermelha',
        };
    }
}
