<?php

namespace App\Console\Commands;

use App\Models\DitoNumber;
use App\Models\NewCarPart;
use Illuminate\Console\Command;

class FindDitoNumberFromDanishPartCodeCommand extends Command
{
    protected $signature = 'car-parts:danish:find-dito-number';

    public function handle(): int
    {
        $parts = NewCarPart::where('country', 'DK')
            ->whereNull('dito_number_id')
            ->whereNotNull('danish_item_code')
            ->take(10000)
            ->get();

        $this->info($parts->count());

        foreach ($parts as $part) {
            $ditoNumberPartCode = substr($part->danish_item_code, 4, 4);
            $ditoNumberCarCode = substr($part->danish_item_code, 0, 4);
            $ditoNumber = DitoNumber::where('dito_number', $ditoNumberCarCode)->first();

            //$this->info($ditoNumberCarCode);

            $part->dito_number_part_code = $ditoNumberPartCode;

            if($ditoNumber) {
                $this->info($ditoNumber->id);
                $part->dito_number_id = $ditoNumber->id;
            }

            $part->save();
        }

        return Command::SUCCESS;
    }
}
