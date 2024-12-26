<?php

namespace App\Console\Commands;

use App\Models\DanishCarPartType;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class FindCarPartTypeIdForDanishPartsCommand extends Command
{
    protected $signature = 'car-parts:danish:find-part-type';

    public function handle(): int
    {
        $parts = $this->parts();

        foreach($parts as $part) {
            $carPartTypeId = DanishCarPartType::where('code', $part->dito_number_part_code)
                ->first()
                ?->carPartTypes
                ?->first()
                ?->id;

            if(!$carPartTypeId) {
                $this->info("$part->dito_number_part_code not found!");

                continue;
            }

            $part->car_part_type_id = $carPartTypeId;
            $part->save();
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $parts = NewCarPart::where('country', 'DK')
            ->whereNull('car_part_type_id')
            ->whereNotNull('dito_number_part_code')
            ->get();

        return $parts;
    }
}
