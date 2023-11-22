<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class FenixResolveCarPartImagesCommandForEbay extends Command
{
    protected $signature = 'fenix:resolve-images-ebay';

    public function handle(): int
    {
        $parts = NewCarPart::select('id')
            ->whereHas('carPartImages', function($query) {
                $query->whereNull('image_name_blank_logo');
            })
            ->with(['carPartImages' => function($query) {
                $query->whereNull('image_name_blank_logo');
            }])
            ->take(1000)
            ->get();

        logger($parts);

//        foreach ($parts as $part) {
//
//        }

        return Command::SUCCESS;
    }
}
