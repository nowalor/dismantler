<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use Illuminate\Console\Command;

class AddPlaceholderImgToCarPartCommand extends Command
{
    protected $signature = 'car-part:add-placeholder-img';

    public function handle(): int
    {
        NewCarPart::whereDoesntHave('carPartImages')->each(function(NewCarPart $newCarPart) {
            $newCarPart->images()->create([
                'url' => 'https://via.placeholder.com/150'
            ]);
        });

        return Command::SUCCESS;
    }
}
