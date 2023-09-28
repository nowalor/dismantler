<?php

namespace App\Console\Commands;

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
        $carParts = NewCarPart::with('carPartImages')
            ->where('dismantle_company_name', 'like', '%N%')
            ->get();

        foreach ($carParts as $carPart) {
            foreach ($carPart->carPartImages as $index => $carPartImage) {
                if($carPartImage->image_name != null) {
                    continue;
                }

                $imageUrl = $carPartImage->original_url;

                // Download the image
                $imageContents = file_get_contents($imageUrl);
                $tempImagePath = tempnam(sys_get_temp_dir(), 'image');
                file_put_contents($tempImagePath, $imageContents);

                // Load the custom logo
                $logoPath = public_path('img/logo.png');
                $logo = Image::make($logoPath);

                // Load and process the image
                $processedImage = Image::make($tempImagePath);

                $scalingHeight = $this->getScalingHeight($carPart->dismantle_company_name);
                // Determine the position to place the logo (top right corner)
                $logoWidth = (int)(0.27 * $processedImage->width());
                $logoHeight = (int)($scalingHeight * $processedImage->height());
                $xOffset = $processedImage->width() - $logoWidth;
                $yOffset = 0;

                // Resize the logo to fit the desired dimensions
                $logo->resize($logoWidth, $logoHeight);

                // Replace the region in the image with the logo
                $processedImage->insert($logo, 'top-left', $xOffset, $yOffset);

                // Define the output path and name
                try {
                    Storage::disk('public')->makeDirectory('img/car-part/' . $carPartImage->new_car_part_id);

                    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

                    $carImageNumber = $index + 1;

                    $outputName = 'image' . $carImageNumber . '.' . $extension;

                    Storage::disk('public')->put("img/car-part/{$carPartImage->new_car_part_id}" . '/' . $outputName, $processedImage->stream());
//                $processedImage->save(public_path("storage/img/car-part/{$carPartImage->new_car_part_id}" . '/' . $outputName));

                    $carPartImage->image_name = $outputName;
                    $carPartImage->priority = $carImageNumber;
                    $carPartImage->save();
                } catch (Exception $e) {
                    $this->error('Directory creation failed: ' . $e->getMessage());
                    return Command::FAILURE;
                }


                // Clean up temporary image file
                unlink($tempImagePath);
            }
        }


        $this->info('Image processing completed.');

        return Command::SUCCESS;
    }

    private function getScalingHeight(string $dismantleCompany): float
    {
        logger($dismantleCompany);
        $height = 0.29;

        if($dismantleCompany === 'F') {
            $height = 0.38;
        }

        return $height;
    }
}

