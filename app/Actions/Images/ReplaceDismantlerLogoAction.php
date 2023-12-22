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
        string $cornerPosition = 'top-right' // Default to top-right if not specified
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

        // Determine the position to place the logo
        [$xOffset, $yOffset] = $this->calculateOffset($processedImage, $replacementImage, $cornerPosition);

        // Resize the logo to fit the desired dimensions
        $logoWidth = (int)(0.27 * $processedImage->width());
        $logoHeight = (int)($scalingHeight * $processedImage->height());
        $replacementImage->resize($logoWidth, $logoHeight);

        // Replace the region in the image with the logo
        $processedImage->insert($replacementImage, $cornerPosition, $xOffset, $yOffset);

        return [
            'image' => $processedImage,
            'temp_image_path' => $tempImagePath,
        ];
    }

    private function calculateOffset(
        InterventionImage $processedImage,
        InterventionImage $replacementImage,
        string $cornerPosition
    ): array
    {
        switch ($cornerPosition) {
            case 'top-right':
                $xOffset = $processedImage->width() - $replacementImage->width();
                $yOffset = 0;
                break;
             /*
             * Calculation does not work 100%
             * But it's good enough to replace ethe small logo for GB
             */
            case 'bottom-left':
                $xOffset = 0;
                $yOffset = $processedImage->height() - ($replacementImage->height() * 2);
                break;
            case 'bottom-right':
                $xOffset = $processedImage->width() - $replacementImage->width();
                $yOffset = $processedImage->height() - $replacementImage->height();
                break;
            default:
                $xOffset = 0;
                $yOffset = 0;
                break;
        }

        return [$xOffset, $yOffset];
    }
}
