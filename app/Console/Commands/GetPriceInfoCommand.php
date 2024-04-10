<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use Illuminate\Console\Command;
use App\Models\CarPartType;


class GetPriceInfoCommand extends Command
{
    protected $signature = 'price:info';

    public function handle(): array
    {
//        $types = CarPartType::whereHas('carParts', function($q) {
//            return $q->where('is_live', true);
//        })->with("carParts")->get();
//
//        $totals = [];
//        $total = 0;
//
//        foreach ($types as $type) {
//            $totalForPart =
//                $type->carParts->sum("new_price") + $type->carParts->sum("shipment");
//
//            $totals[$type->name] = $totalForPart;
//            $total += $totalForPart;
//        }
//
//        foreach($totals as $key => $toPrint) {
//            $this->info("$key: $toPrint");
//        }
//
//        $this->info("All parts: $total");

        $parts = NewCarPart::where('car_part_type_id', '3')
            ->where('model_year', '>', '2008')
            ->where('model_year', '<', '2020')
            ->get();

        $price = 0;
        foreach($parts as $part) {
            $price += ($part->new_price + $part->shipment);
        }

        $this->info("Price is $price");
        return [];
    }
}
