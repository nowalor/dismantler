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
            "http://46.101.206.99/storage/img/car-part/18792/image1.jpg";

        $hash1 = md5(file_get_contents($imageUrl1));

        $images = NewCarPart::where('dismantle_company_name', 'GB')
            ->with('carPartImages')
            ->get()
            ->pluck('carPartImages')
            ->flatten();

        foreach($images as $key => $image) {
            $this->info("on $key");

            if($image->image_name_blank_logo === null) {
                continue;
            }

            $hash2 = md5(file_get_contents(asset("storage/img/car-part/$image->new_car_part_id/$image->image_name")));

            if($hash1 === $hash2) {
                $image->is_placeholder = true;
                $image->save();
            } else {
                echo $hash2;
            }
        }


        return Command::SUCCESS;
    }
}
