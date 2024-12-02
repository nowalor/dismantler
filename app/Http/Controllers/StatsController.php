<?php

namespace App\Http\Controllers;

use App\Actions\Parts\GetOptimalPartsAction;
use App\Models\NewCarPart;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        //$partTypeIds = [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
        $partTypeIds = [9];


        $oems = NewCarPart::whereIn('car_part_type_id', $partTypeIds)->distinct('original_number')->pluck('original_number');

        $sum = 0;
        foreach($oems as $oem){
            $optimalParts = (new GetOptimalPartsAction())->execute($oem);

            foreach($optimalParts as $optimalPart){
                $sum += $optimalPart->price_eur;
            }
        }

        return $sum;
    }
}
