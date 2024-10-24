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
            ],
            'VI' => [
                'name' => 'VI',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.18',
            ],
            'H' => [
                'name' => 'h',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.20',
            ],
        ];

        $carParts = NewCarPart::select(["id", "dismantle_company_name"])
            ->whereHas('carPartImages', function ($query) {
                $query->whereNull('new_logo_german');
            })
            ->with(['carPartImages' => function ($query) {
                $query->whereNull('new_logo_german');
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
               /* ->whereIn('car_part_type_id', [1, 2, 3, 4, 5, 6, 7])*/
             ->whereIn('sbr_part_code',  [
                "4626", // screens
                "7470",
                "7487",
                "7816",
                "3230",
                "7255",
                "7295",
                "7393",
                "7411",
                "7700",
                "7835",
            ])
         /*       ->where('dismantle_company_name', 'h')*/
            ->take(650)
            ->where('id', '!=', 156711042137) // TODO, figure out why this one does not work
            ->get();

//        $carParts = NewCarPart::where('id', 32960)->get();

        foreach ($carParts as $carPart) {
            $dismantlerCompany = $dismantlers[$carPart->dismantle_company_name];
            $this->info($dismantlerCompany['name']);
            $this->info($carPart->id);

            $replacementImagePath = $dismantlerCompany['logoPath'];
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

                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/german-logo", $tempFilePath, $outputName, 'public');
                  //  Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/new-logo", $tempFilePath, $outputName, 'public');
//                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/newsest-testing9", $tempFilePath, $outputName, 'public');


                    $image->new_logo_german = $outputName;
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
