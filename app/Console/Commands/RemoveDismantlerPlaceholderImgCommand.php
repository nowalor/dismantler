<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class RemoveDismantlerPlaceholderImgCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dismantler-placeholder-remove';

    public function handle(): int
    {
        $imageUrl1 =
            "https://fenixapi-image.bosab.se/api/File/Download/1/GB/125020_1_GB.jpg";

        $hash1 = md5(file_get_contents($imageUrl1));

        $images = NewCarPart::where('dismantle_company_name', 'GB')
            ->with('carPartImages')
            ->get()
            ->pluck('carPartImages')
            ->flatten();

        foreach($images as $image) {
            $imageUrl2 = $image->original_url;
            $hash2 = md5(file_get_contents($imageUrl2));

            if($hash1 === $hash2) {
                $image->is_placeholder = true;
                $image->save();
            } else {
                echo asset("storage/img/car-part/$image->new_car_part_id/$image->image_name");
            }
        }


        return Command::SUCCESS;
    }
}
