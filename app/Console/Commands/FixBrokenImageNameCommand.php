<?php

namespace App\Console\Commands;

use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class FixBrokenImageNameCommand extends Command
{
    protected $signature = 'fix:images';

    public function handle(): int
    {
        $images = NewCarPartImage::where('image_name', 'like', '%https%')->get();

        foreach($images as $image) {
            $imagesFromSamePart = NewCarPartImage::where(
                'new_car_part_id',
                $image->new_car_part_id
            )->get();

            foreach($imagesFromSamePart as $index => $imageFromSamePart) {
                $imageFromSamePart->image_name = 'image' . ($index + 1) . '.jpg';
                $imageFromSamePart->save();
            }
        }

        return Command::SUCCESS;
    }
}
