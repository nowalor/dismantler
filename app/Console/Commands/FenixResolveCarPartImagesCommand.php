<?php

namespace App\Console\Commands;

use App\Actions\Images\ReplaceDismantlerLogoAction;
use App\Models\CarPart;
use App\Models\NewCarPart;
use Exception;
use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\NewCarPartImage;

class FenixResolveCarPartImagesCommand extends Command
{
    protected $signature = 'fenix:resolve-images';

    protected $description = 'Take the image url we get from the Fenix API. Run it through a python script to replace the dismantle company logo with our own logo';

    public function handle(): int
    {
        $dismantlers = [
            'A' => [
                'name' => 'a',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.20',
            ],
            'S' => [
                'name' => 's',
                'logoPath' => public_path('img/dismantler/s/logo.png'),
                'scalingHeight' => '0.29',
            ],
            // WORKS
            'W' => [
                'name' => 'w',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.28',
            ],
            'BO' => [
                'name' => 'bo',
                'logoPath' => public_path('img/dismantler/bo/logo.png'),
                'scalingHeight' => '0.30',
            ],
            'N' => [
                'name' => 'n',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.15',
            ],
            'AL' => [
                'name' => 'n',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.15',
            ],
            // WORKS
            'P' => [
                'name' => 'p',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            // TODO
            'D' => [
                'name' => 'd',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            'LI' => [
                'name' => 'li',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            'GB' => [
                'name' => 'gb',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            'F' => [
                'name' => 'f',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            'AA' => [
                'name' => 'aa',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',

            ],
            'BB' => [
                'name' => 'bb',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',

            ],
            'CC' => [
                'name' => 'CC',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ]

        ];

        $carParts = NewCarPart::select(["id", "dismantle_company_name"])
            ->whereHas('carPartImages', function ($query) {
                $query->whereNull('image_name_blank_logo');
            })
            ->with(['carPartImages' => function ($query) {
                $query->whereNull('image_name_blank_logo');
            }])
            ->with('carPartImages')
//            ->where('dismantle_company_name', 'A')
//            ->whereNotNull('engine_code')
         /*   ->whereIn('external_part_type_id', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)*/
//            ->where('engine_code', '!=', '')
//            ->has('germanDismantlers')
//            ->where('price_sek', '>', 0)
//            ->whereNotNull('price_sek')
//            ->where('price_sek', '!=', '')
//            ->whereNull('sold_at')
        /*    ->whereIn('dismantle_company_name', ['AA', 'BB', 'CC'])*/
                ->where('car_part_type_id', 1)
            ->take(300)
            ->get();

        $carParts = NewCarPart::where('car_part_type_id', 1)->where('engine_code', '!=', '')->whereNotNull('engine_code')->where('model_year', '>', 2002)->whereNull('sold_at')->whereNotNull('article_nr')->where(function ($q) {$q->where('fuel', 'Diesel')->orWhere('fuel', 'Bensin');})->whereHas('germanDismantlers.kTypes')->whereNotNull('price_eur') ->whereHas('carPartImages', function ($q) {$q->whereNull('image_name_blank_logo');})->get();

//        $carParts = NewCarPart::where('id', 32960)->get();

        foreach ($carParts as $carPart) {
            $dismantlerCompany = $dismantlers[$carPart->dismantle_company_name];
            $replacementImagePath = $dismantlerCompany['logoPath'];
            $replacementImagePath = public_path('img/blank.png');
            $scalingHeight = $dismantlerCompany['scalingHeight'];

            foreach ($carPart->carPartImages as $index => $image) {
//                if($image->image_name !== null) {
//                    continue;
//                }

                $replacementImage = Image::make($replacementImagePath); // Move this inside the loop

                $position = $carPart->dismantle_company_name === 'GB' ? 'bottom-right' : 'top-right';

                $response = (new ReplaceDismantlerLogoAction())
                    ->handle(
                        imageUrl: $image->original_url,
                        replacementImage: $replacementImage,
                        scalingHeight: $scalingHeight,
                        position: $position,
                    );

                if (!$response) {
                    continue;
                }

                $processedImage = $response['image'];
                $tempImagePath = $response['temp_image_path'];

                // Define the output path and name
                try {

                    $extension = 'jpg';

                    $carImageNumber = $index + 1;

                    $outputName = 'image' . $carImageNumber . '.' . $extension;

                    $stream = $processedImage->stream();
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'processed_image');
                    file_put_contents($tempFilePath, $stream);

                    $this->info($image->new_car_part_id);
                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/logo-blank", $tempFilePath, $outputName, 'public');
                  //  Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/new-logo", $tempFilePath, $outputName, 'public');
//                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/newsest-testing9", $tempFilePath, $outputName, 'public');


                    //$image->new_logo_german = $outputName;
                    $image->image_name_blank_logo = $outputName;
                    $image->priority = $carImageNumber;
                    $image->save();

                    if (file_exists($tempImagePath)) {
                        unlink($tempImagePath);
                    }

                    if (file_exists($tempFilePath)) {
                        unlink($tempFilePath);
                    }
//
//

                } catch (Exception $e) {
                    $this->error('Directory creation failed: ' . $e->getMessage());
                    return Command::FAILURE;
                }


            }
        }


        $this->info('Image processing completed.');

        return Command::SUCCESS;
    }

    private function getScalingHeight(string $dismantleCompany): float
    {
        $height = 0.29;
//        $height = 0.20;

//        $height = 0.27;
//        $height = 0.31;
        if ($dismantleCompany === 'F') {
            $height = 0.38;
        }

        return $height;
    }
}
