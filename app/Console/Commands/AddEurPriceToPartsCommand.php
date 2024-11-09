<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\NewCarPart;
use Illuminate\Console\Command;

class AddEurPriceToPartsCommand extends Command
{
    protected $signature = 'parts:add-eur-price';


    public function handle(): int
    {
        $parts = NewCarPart::whereIn('sbr_part_code', [
            "7201",
            "7280",
            "7704",
            "7705",
            "7706",
            "7868",
            "7860",
            "7070",
            "7145",
            "7143",
            "7302",
            "7816",
            "3230",
            "7255",
            "7295",
            "7393",
            "7411",
            "7700",
            "7835",
            "3135",
            "1020",
            "1021",
            "1022",
            "4638",
            "3235",
            "3245",
            "4573",
            "7050",
            "7051",
            "7052",
            "7070",
            "7475",
            "7645",
            "3220",
            "7468",
            "7082",
            "4626",
            "7470",
            "7487"
        ])
/*        whereIn('external_part_type_id', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)*/
//            ->orWhereNull('country')
            ->get();

        foreach($parts as $part) {
            if($part->country === '') {
                continue;
            }

           $divider = $part->country === 'DK' ? 7.47 : 11.49;
            $price = $part->country === 'DK' ? $part->price_dkk : $part->price_sek;
//
           $part->price_eur = $price / $divider;
      /*     $part->mileage = $part->country === 'DK' ? $part->mileage_km : $part->mileage_km / 10;*/

            $part->mileage_km = $part->mileage * 10;
            $part->save();
        }

        return Command::SUCCESS;
    }
}
