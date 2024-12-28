<?php

namespace App\Enums;

enum TargetLanguages: string
{
    case DK = 'DA'; // Danish
    case FR = 'FR'; // French
    case SE = 'SV'; // Swedish
    case GE = 'DE'; // German
    case IT = 'IT'; // Italian
    case PL = 'PL'; // Polish

    public static function getLanguages(): array
    {
        return [
            'da' => self::DK->value,
            'fr' => self::FR->value,
            'sv' => self::SE->value,
            'ge' => self::GE->value,
            'it' => self::IT->value,
            'pl' => self::PL->value,
        ];
    }
}
