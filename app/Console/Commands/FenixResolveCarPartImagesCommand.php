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
        $replacementImagePath = public_path('img/dismantler/a/logo.png');
        $replacementImage = Image::make($replacementImagePath);

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
//            ->whereIn('external_part_type_id', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)
//            ->where('engine_code', '!=', '')
//            ->has('germanDismantlers')
//            ->where('price_sek', '>', 0)
//            ->whereNotNull('price_sek')
//            ->where('price_sek', '!=', '')
//            ->whereNull('sold_at')
            ->where('article_nr', 'like', 'W%')
            ->take(255)
            ->get();

//        $carParts = NewCarPart::where('id', 36272)->get();

        foreach ($carParts as $carPart) {
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
                        scalingHeight: $this->getScalingHeight($carPart->dismantle_company_name),
                        position: $position,
                    );

                if(!$response) {
                    continue;
                }

                $processedImage = $response['image'];
                $tempImagePath = $response['temp_image_path'];

                // Define the output path and name
                try {
//                    Storage::disk('public')->makeDirectory('img/car-part/' . $image->new_car_part_id);

//                    $extension = pathinfo($image->original_url, PATHINFO_EXTENSION);
                    $extension = 'jpg';

                    $carImageNumber = $index + 1;

                    $outputName = 'image' . $carImageNumber . '.' . $extension;

                    $stream = $processedImage->stream();
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'processed_image');
                    file_put_contents($tempFilePath, $stream);
//
                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/german-logo", $tempFilePath, $outputName, 'public');
                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/new-logo", $tempFilePath, $outputName, 'public');
//                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/newsest-test3", $tempFilePath, $outputName, 'public');



                    $image->new_logo_german = $outputName;
                    $image->priority = $carImageNumber;
                    $image->save();

                    $this->info("test1: $tempImagePath");
                    $this->info("test2: {$response['temp_image_path']}");
                    if (file_exists($tempImagePath)) {
                        unlink($tempImagePath);
                    }

                    if(file_exists($response['temp_image_path'])) {
                        unlink($response['temp_image_path']);
                    }

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
//        $height = 0.29;
        $height = 0.20;

//        $height = 0.27;
//        $height = 0.31;
        if($dismantleCompany === 'F') {
            $height = 0.38;
        }

        return $height;
    }
}
