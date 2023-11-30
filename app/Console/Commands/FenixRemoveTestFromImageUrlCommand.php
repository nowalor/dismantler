<?php

namespace App\Console\Commands;

use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class FenixRemoveTestFromImageUrlCommand extends Command
{
    protected $signature = 'fenix:fix-img-url';

    public function handle(): int
    {
        $images = NewCarPartImage::select(['id', 'original_url'])->get();

        $images->each(function ($image) {
            $newUrl = str_replace('-fenixapi', 'fenixapi', $image->original_url);

            $image->original_url = $newUrl;
            $image->save();
        });

        return Command::SUCCESS;
    }
}
