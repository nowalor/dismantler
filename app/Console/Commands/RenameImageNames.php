<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewCarPart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RenameImageNames extends Command
{
    protected $signature = 'command:renameImageNames';
    protected $description = 'Rename “image1.jpg” etc. to something more SEO-friendly.';

    public function handle()
    {
        $renamedCarParts = [];

        // Load a small batch of 10 car parts to rename:
        $carParts = NewCarPart::with('carPartImages')->limit(10)->get();

        foreach ($carParts as $part) {
            $carNameSlug = Str::slug($part->sbr_car_name, '-');
            $counter = 1;
            $didRename = false;

            // Check if carPartImages relationship has data
            if ($part->carPartImages->isEmpty()) {
                $this->info("No images found for car part: {$part->sbr_car_name} (ID: {$part->id})");
                continue;
            }

            foreach ($part->carPartImages as $image) {
                if (Str::startsWith($image->new_logo_german, 'image')) {
                    $extension = pathinfo($image->new_logo_german, PATHINFO_EXTENSION);
                    $newFileName = $carNameSlug . '-' . $counter . '.' . $extension;

                    $oldPath = "img/car-part/{$part->id}/german-logo/{$image->new_logo_german}";
                    $newPath = "img/car-part/{$part->id}/german-logo/{$newFileName}";

                    try {
                        Storage::disk('spaces')->move($oldPath, $newPath);

                        $image->new_logo_german = $newFileName;
                        $image->save();

                        $didRename = true;
                        $counter++;
                        $this->info("Renamed $oldPath -> $newPath");
                    } catch (\Exception $e) {
                        $this->error("Failed to rename $oldPath: " . $e->getMessage());
                    }
                }
            }

            if ($didRename) {
                $renamedCarParts[] = $part->sbr_car_name . " (ID: {$part->id})";
            }
        }

        if (!empty($renamedCarParts)) {
            $this->info('Renamed images for the following car parts:');
            foreach ($renamedCarParts as $carPartInfo) {
                $this->info(" - {$carPartInfo}");
            }
        } else {
            $this->info('No images were renamed in this batch.');
        }

        $this->info('Renaming complete for this batch of 10 car parts.');
        return Command::SUCCESS;
    }
}
