<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadBlogImageAction
{
    public function execute(UploadedFile $file, ?string $oldImageUrl = null): string
    {
        // If there's an old image, delete it first
        if ($oldImageUrl) {
            $this->delete($oldImageUrl);
        }

        $imageName = time() . '_' . $file->getClientOriginalName();
        $folder = 'img/blog-image';
        $filePath = $folder . '/' . $imageName;

        Storage::disk('do')->put($filePath, file_get_contents($file), [
            'visibility' => 'public',
            'ACL' => 'public-read',
            'ContentType' => $file->getMimeType(),
        ]);

        // Return the full CDN URL
        $cdnUrl = rtrim(env('DO_CDN_ENDPOINT'), '/');
        return $cdnUrl . '/' . $filePath;
    }

    public function delete(string $imageUrl): void
    {
        $relativePath = parse_url($imageUrl, PHP_URL_PATH);
        // remove extra slash
        $relativePath = ltrim($relativePath, '/');
        Storage::disk('do')->delete($relativePath);
    }
}
