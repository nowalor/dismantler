<?php

namespace App\Console\Commands;

use App\Actions\Images\ReplaceDismantlerLogoAction;
use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FenixResolveCarPartImagesCommandForEbay extends Command
{
    protected $signature = 'fenix:resolve-images-ebay';

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
            'bo' => [
                'name' => 'bo',
                'logoPath' => public_path('img/dismantler/s/logo.png'),
                'scalingHeight' => '0.29',
            ],
            'n' => [
                'name' => 'n',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.17',
            ],
            'p' => [
                'name' => 'p',
                'logoPath' => public_path('img/dismantler/a/logo.png'),
                'scalingHeight' => '0.24',
            ]
        ];


        // Load the white blank image to replace the logo with
        $replacementImagePath = public_path('img/blank.png');
        $replacementImage = Image::make($replacementImagePath);

        $parts = NewCarPart::select(["id", "dismantle_company_name"])
                        ->whereHas('carPartImages', function ($query) {
                            $query->whereNull('image_name_blank_logo');
                        })
                        ->with(['carPartImages' => function ($query) {
                            $query->whereNull('image_name_blank_logo');
                        }])
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
            ->whereIn('car_part_type_id', [1,2,3,4,5,6,7])
//            ->has('germanDismantlers')
            ->where('price_sek', '>', 0)
            ->whereNotNull('price_sek')
            ->where('price_sek', '!=', '')
            ->whereNull('sold_at')
            ->take(520)
            ->get();

//        $parts = NewCarPart::where('id', 239)->get();

        foreach ($parts as $part) {
            $dismantleCompany = $part->dismantle_company_name;
//            $dismantlerInfo = $dismantlers[$dismantleCompany];

//            if(empty($dismantlerInfo)) {
//                continue;
//            }

//            $replacementImagePath = public_path("img/dismantler/{$dismantlerInfo['logoPath']}/logo.png");
            $scalingHeight = $this->getScalingHeight($part->dismantle_company_name);


            $dismantleCompany = $part->dismantle_company_name;

            foreach ($part->carPartImages as $index => $image) {
                $imageUrl = $image->original_url;

                $position = $part->dismantle_company_name === 'GB' ? 'bottom-right' : 'top-right';

                $response = (new ReplaceDismantlerLogoAction())
                    ->handle(
                        imageUrl: $imageUrl,
                        replacementImage: $replacementImage,
                        scalingHeight: $this->getScalingHeight($dismantleCompany),
                        position: $position,
                    );

                if (!$response) {
                    continue;
                }

                $processedImage = $response['image'];
                $tempImagePath = $response['temp_image_path'];

                // Define the output path and name
                try {
                    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

                    $carImageNumber = $index + 1;

                    $outputName = 'image-blank' . $carImageNumber . '.' . $extension;


                    $stream = $processedImage->stream();
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'processed_image');
                    file_put_contents($tempFilePath, $stream);

                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/logo-blank", $tempFilePath, $outputName, 'public');

                    $image->image_name_blank_logo = $outputName;
                    $image->priority = $carImageNumber;
                    $image->save();
                } catch (Exception $e) {
                    $this->error('Directory creation failed: ' . $e->getMessage());

                    return Command::FAILURE;
                }


                // Clean up temporary image file
                unlink($tempImagePath);
            }
        }

        return Command::SUCCESS;
    }

    private function getScalingHeight(string $dismantleCompany): float
    {
        $height = 0.32;

        if ($dismantleCompany === 'F') {
            $height = 0.38;
        }

        return $height;
    }
}
