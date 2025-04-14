<?php

namespace App\Enums;

enum FenixDismantlerEnum: string
{
    case W = 'W';
    case P = 'P';
    case A = 'A';
    case BO = 'BO';
    case F = 'F';
    case N = 'N';
    case AL = 'AL';
    case S = 'S';
    case GB = 'GB';
    case LI = 'LI';
    case D = 'D';
    case VI = 'VI';
    case H = 'H';
/*    case AS = 'AS';*/

    public static function next(string | null $current): self
    {
        $cases = self::cases();

        if (is_null($current)) {
            return $cases[0];
        }

        foreach ($cases as $i => $case) {
            if ($case->value === strtoupper($current)) {
                return $cases[($i + 1) % count($cases)];
            }
        }

        throw new \InvalidArgumentException("Invalid dismantler: {$current}");
    }
}
