<?php

namespace App\Actions\Images;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;

class ReplaceDismantlerLogoAction
{
    public function handle(
        string $imageUrl,
        InterventionImage  $replacementImage,
        float  $scalingHeight,
        string $position,
    ): array|bool
    {
        // Download the image
        $imageContents = @file_get_contents($imageUrl);

        if (!$imageContents) {
            return false;
        }
        $tempImagePath = tempnam(sys_get_temp_dir(), 'image');
        file_put_contents($tempImagePath, $imageContents);


        // Temporary save the image to validate MIME type
        $tempImagePath = tempnam(sys_get_temp_dir(), 'image');
        file_put_contents($tempImagePath, $imageContents);

        // Check if the downloaded file is a supported image
        $mimeType = mime_content_type($tempImagePath);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'])) {
            Log::error("Unsupported image MIME type: {$mimeType} at URL: {$imageUrl}");
            unlink($tempImagePath); // Clean up the temp file
            return false;
        }

        // Load and process the image
        $processedImage = Image::make($tempImagePath);

        // Determine the position to place the logo (top right corner)
//        $logoWidth = (int)(0.27 * $processedImage->width());
        $logoHeight = (int)($scalingHeight * $processedImage->height());

        $replacementImage->resize(null, $logoHeight, function ($constraint) {
            $constraint->aspectRatio();
        });

        $logoWidth = $replacementImage->width();

        [$xOffset, $yOffset] = $this->calculateOffset($processedImage, $logoHeight, $logoWidth, $position);
//        $xOffset = $processedImage->width() - $logoWidth;
//        $yOffset = 0;

        // Resize the logo to fit the desired dimensions

        // Replace the region in the image with the logo
        $processedImage->insert($replacementImage, 'top-left', $xOffset, $yOffset);

        return [
            'image' => $processedImage,
            'temp_image_path' => $tempImagePath,
        ];
    }

    private function calculateOffset(
        InterventionImage $processedImage,
        int $logoHeight,
        int $logoWidth,
        string $position
    ): array
    {
        switch ($position) {
            case 'top-right':
                $xOffset = $processedImage->width() - $logoWidth;
                $yOffset = 0;
                break;
            /*
            * Calculation does not work 100%
            * But it's good enough to replace ethe small logo for GB
            */
            case 'bottom-left':
                $xOffset = 0;
                $yOffset = $processedImage->height() - $logoHeight;
                break;
            case 'bottom-right':
                $xOffset = $processedImage->width() - $logoWidth;
                $yOffset = $processedImage->height() - $logoHeight;
                break;
            default:
                $xOffset = 0;
                $yOffset = 0;
                break;
        }

        return [$xOffset, $yOffset];
    }
}
