<?php

namespace App\Services;

class CalculatePriceService
{
    public function sekToEurForFenix(float $price, int $partTypeId): float
    {
        if (
            $partTypeId === 3 ||
            $partTypeId === 4
        ) {
            $addition = 110;
        } else if (
            $partTypeId === 2 ||
            $partTypeId === 5 ||
            $partTypeId === 7
        ) {
            $addition = 60;
        } else if ($partTypeId === 6) {
            $addition = 70;
        } else if ($partTypeId === 1) {
            $addition = 200;
        }

        if(!$addition) {
            throw new \Exception('No addition found for part type id: ' . $partTypeId);
        }

        return round(($price / 10 + $addition) * 1.19);
    }
}
