<?php

namespace App\Actions\Images;

use Intervention\Image\Facades\Image;

class ReplaceDismantlerLogoAction
{
    public function handle(
        string $imageUrl,
        string $replacementImage,
        float $scalingHeight
    ): \Intervention\Image\Image
    {
        // Download the image
        $imageContents = file_get_contents($imageUrl);
        $tempImagePath = tempnam(sys_get_temp_dir(), 'image');
        file_put_contents($tempImagePath, $imageContents);

        // Load the custom logo
        $logoPath = public_path('img/logo.png');
        $logo = Image::make($logoPath);

        // Load and process the image
        $processedImage = Image::make($tempImagePath);

        // Determine the position to place the logo (top right corner)
        $logoWidth = (int)(0.27 * $processedImage->width());
        $logoHeight = (int)($scalingHeight * $processedImage->height());
        $xOffset = $processedImage->width() - $logoWidth;
        $yOffset = 0;

        // Resize the logo to fit the desired dimensions
        $logo->resize($logoWidth, $logoHeight);

        // Replace the region in the image with the logo
        $processedImage->insert($logo, 'top-left', $xOffset, $yOffset);

        return $processedImage;
    }
}
