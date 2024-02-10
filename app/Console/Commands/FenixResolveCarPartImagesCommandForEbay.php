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
        // Load the white blank image to replace the logo with
        $replacementImagePath = public_path('img/blank.png');
        $replacementImage = Image::make($replacementImagePath);

        $parts = NewCarPart::select(["id", "dismantle_company_name"])
//                        ->whereHas('carPartImages', function ($query) {
//                            $query->whereNull('image_name_blank_logo');
//                        })
//                        ->with(['carPartImages' => function ($query) {
//                            $query->whereNull('image_name_blank_logo');
//                        }])
            ->whereHas("carPartImages")
            ->with("carPartImages")
            ->where('id', 1)
            ->get();

        foreach ($parts as $part) {
            $dismantleCompany = $part->dismantle_company_name;

            foreach ($part->carPartImages as $index => $image) {
                $imageUrl = $image->original_url;

                $response = (new ReplaceDismantlerLogoAction())
                    ->handle(
                        imageUrl: $imageUrl,
                        replacementImage: $replacementImage,
                        scalingHeight: $this->getScalingHeight($dismantleCompany),
                        position: 'bottom-left',
                    );

                if(!$response) {
                    continue;
                }

                $processedImage = $response['image'];
                $tempImagePath = $response['temp_image_path'];

                // Define the output path and name
                try {
                    Storage::disk('public')->makeDirectory('img/car-part/' . $image->new_car_part_id);

                    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

                    $carImageNumber = $index + 1;

                    $outputName = 'image-blank' . $carImageNumber . '.' . $extension;

                    Storage::disk('public')->put("img/car-part/{$image->new_car_part_id}" . '/' . $outputName, $processedImage->stream());

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
        $height = 0.29;

        if ($dismantleCompany === 'F') {
            $height = 0.38;
        }

        return $height;
    }
}
