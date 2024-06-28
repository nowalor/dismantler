<?php

namespace App\Actions\Images;

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

        // Load and process the image
        $processedImage = Image::make($tempImagePath);

        // Calculate the height for the logo and scale proportionally
        $logoHeight = (int)($scalingHeight * $processedImage->height());

        // Use the fit method to resize while maintaining aspect ratio
        $replacementImage->fit(null, $logoHeight, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Calculate the new width of the logo
        $logoWidth = $replacementImage->width();

        [$xOffset, $yOffset] = $this->calculateOffset($processedImage, $logoHeight, $logoWidth, $position);

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
