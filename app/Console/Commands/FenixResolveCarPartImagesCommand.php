<?php

namespace App\Console\Commands;

use App\Actions\Images\ReplaceDismantlerLogoAction;
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
        $logos = [
            [
                'folder' => 'german-logo',
                'image_name' => 'new-logo-german.jpg',
                'db_field' => 'new_logo_german',
            ],
            [
                'folder' => 'english-logo',
                'image_name' => 'new-logo-english.jpg',
                'db_field' => 'new_logo_english',
            ],
            [
                'folder' => 'danish-logo',
                'image_name' => 'new-logo-danish.jpg',
                'db_field' => 'new_logo_danish',
            ],
            [
                'folder' => 'old_logo',
                'image_name' => 'logo.png',
                'db_field' => 'image_name',
            ],
        ];

        foreach($logos as $logo) {
            // TODO
        }

        $replacementImagePath = public_path('img/new-logo-german.jpg');
        $replacementImage = Image::make($replacementImagePath);

        $carParts = NewCarPart::select(["id", "dismantle_company_name"])
            ->whereHas('carPartImages', function ($query) {
                $query->whereNull('new_logo_german');
            })
            ->with(['carPartImages' => function ($query) {
                $query->whereNull('new_logo_german');
            }])
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
//            ->has('germanDismantlers')
            ->where('price_sek', '>', 0)
            ->whereNotNull('price_sek')
            ->where('price_sek', '!=', '')
            ->whereNull('sold_at')
            ->take(520)
            ->get();

        foreach ($carParts as $carPart) {
            foreach ($carPart->carPartImages as $index => $image) {
                $position = $carPart->dismantle_company_name === 'GB' ? 'bottom-right' : 'top-right';

                $response = (new ReplaceDismantlerLogoAction())
                    ->handle(
                        imageUrl: $image->original_url,
                        replacementImage: $replacementImage,
                        scalingHeight: $this->getScalingHeight($carPart->dismantle_company_name),
                        position: $position,
                    );

                if (!$response) {
                    continue;
                }

                $processedImage = $response['image'];
                $tempImagePath = $response['temp_image_path'];

                // Define the output path and name
                try {
                    $extension = pathinfo($image->original_url, PATHINFO_EXTENSION);

                    $carImageNumber = $index + 1;

                    $outputName = 'image' . $carImageNumber . '.' . $extension;

                    $stream = $processedImage->stream();
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'processed_image');
                    file_put_contents($tempFilePath, $stream);

                    Storage::disk('do')->putFileAs("img/car-part/{$image->new_car_part_id}/german-logo", $tempFilePath, $outputName, 'public');

                    $image->new_logo_german = $outputName;
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


        $this->info('Image processing completed.');

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

