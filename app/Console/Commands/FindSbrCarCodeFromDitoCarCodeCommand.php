<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class FindSbrCarCodeFromDitoCarCodeCommand extends Command
{
    protected $signature = 'car-parts:danish:find-sbr-car-code';

    public function handle(): int
    {
        $parts = $this->parts();

        foreach ($parts as $part) {
            if(!isset($part->ditoNumber?->sbrCodes[0])) {
                continue;
            }

            $part->sbr_code_id = $part->ditoNumber?->sbrCodes[0]?->id;
            $part->sbr_car_code = $part->ditoNumber?->sbrCodes[0]?->sbr_code;

            $part->save();
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $parts = NewCarPart::where('country', 'DK')
            ->whereNotNull('dito_number_id')
            ->whereHas('ditoNumber', function ($query) {
                $query->whereHas('sbrCodes');
            })
            ->whereNull('sbr_car_code')
            ->take(100)
            ->get();

        return $parts;
    }
}
