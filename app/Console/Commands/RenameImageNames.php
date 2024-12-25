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
        // We'll store IDs or names of car parts where at least one image gets renamed:
        $renamedCarParts = [];

        // Load a small batch of 10 car parts to rename:
        $carParts = NewCarPart::limit(10)->get();

        foreach ($carParts as $part) {
            // Make a slug from the car’s name, e.g. “Toyota Corolla” -> “toyota-corolla”
            $carNameSlug = Str::slug($part->sbr_car_name, '-');
            $counter = 1;

            // Flag for whether this part got any images renamed
            $didRename = false;

            // Assuming a relationship: NewCarPart -> images
            // e.g. public function images() { return $this->hasMany(NewCarPartImage::class); }
            foreach ($part->images as $image) {
                // Check if this image is named something like "image1.jpg"
                if (Str::startsWith($image->new_logo_german, 'image')) {

                    // Extract the current extension
                    $extension = pathinfo($image->new_logo_german, PATHINFO_EXTENSION);

                    // Generate the new file name, e.g.: "toyota-corolla-1.jpg"
                    $newFileName = $carNameSlug . '-' . $counter . '.' . $extension;

                    // Build old/new paths for DigitalOcean Spaces
                    $oldPath = "img/car-part/{$part->id}/german-logo/{$image->new_logo_german}";
                    $newPath = "img/car-part/{$part->id}/german-logo/{$newFileName}";

                    // Attempt to move (rename) in DigitalOcean Spaces
                    try {
                        Storage::disk('spaces')->move($oldPath, $newPath);

                        // Update the DB column so future references point to the new file
                        $image->new_logo_german = $newFileName;
                        $image->save();

                        // Because at least one image got renamed, set $didRename
                        $didRename = true;

                        $counter++;
                        $this->info("Renamed $oldPath -> $newPath");
                    } catch (\Exception $e) {
                        // Log or handle any errors here
                        $this->error("Failed to rename $oldPath: " . $e->getMessage());
                    }
                }
            }

            // If this car part had any images renamed, store its name (or ID)
            if ($didRename) {
                $renamedCarParts[] = $part->sbr_car_name . " (ID: {$part->id})";
            }
        }

        // Print which car parts got renamed
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
