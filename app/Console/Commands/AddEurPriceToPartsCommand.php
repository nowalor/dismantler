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
        $parts = NewCarPart::whereIn('external_part_type_id', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)
            ->orWhereNull('country')->get();

        foreach($parts as $part) {
            $divider = $part->country === 'DK' ? 7.47 : 11.49;
            $price = $part->country === 'DK' ? $part->price_dkk : $part->price_sek;

            $part->price_eur = $price / $divider;
            $part->save();
        }

        return Command::SUCCESS;
    }
}
